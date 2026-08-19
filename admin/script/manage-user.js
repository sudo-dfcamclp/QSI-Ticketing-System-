/* ==========================================================
   MANAGE USERS — frontend controller
   -------------------------------------------------------------
   Tinatawag ito ng tab-manager.js sa pamamagitan ng
   initManageUserTab(container) pagkatapos ma-inject yung
   manage-user.php HTML sa loob ng tab panel. HINDI natin
   ginagamit ang 'DOMContentLoaded' dito dahil na-lo-load ang
   script na ito nang dynamic (matapos na ang unang
   DOMContentLoaded ng buong page).

   Lahat ng data (list, add, enable/disable, delete) ay galing
   sa admin/control/manage-user-control.php — AJAX JSON
   endpoint. Walang full page reload kahit kailan.
=========================================================== */

// -----------------------------------------------------------
// GLOBAL CONFIG
// -----------------------------------------------------------
var USER_API_URL = '/ticketing/admin/control/manage-user-control.php';
var USER_PER_PAGE = 6;
var USER_POLL_INTERVAL_MS = 8000; // 8 segundo — "realtime" refresh ng listahan
var USER_CONFIRM_COUNTDOWN = 10;  // segundo bago ma-enable yung "Yes" button

function initManageUserTab(container) {
  var root = container || document;

  var list = root.querySelector('#user-list');
  if (!list) return;

  // Iwasan ang double-binding/double-polling kapag na-open/na-close
  // /na-open ulit yung tab.
  if (list.dataset.userTabBound === 'true') return;
  list.dataset.userTabBound = 'true';

  var rootEl        = root.querySelector('#manage-user-root');
  var loadingEl      = root.querySelector('#user-list-loading');
  var emptyEl        = root.querySelector('#user-list-empty');
  var pagination      = root.querySelector('#user-pagination');
  var liveDot        = root.querySelector('#user-live-dot');
  var liveLabel        = root.querySelector('#user-live-label');

  var state = {
    currentPage: 1,
    isSuperAdmin: rootEl && rootEl.dataset.isSuperAdmin === '1',
    currentUserId: rootEl ? parseInt(rootEl.dataset.currentUserId, 10) || 0 : 0,
    pollTimer: null,
    openMenuId: null
  };


  /* =============================================================
     HELPERS
  ============================================================== */
  function escapeHtml(value) {
    var div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
  }

  function initialsOf(user) {
    var f = (user.f_name || '').trim().charAt(0);
    var l = (user.l_name || '').trim().charAt(0);
    var initials = (f + l).toUpperCase();
    return initials || (user.username || '?').charAt(0).toUpperCase();
  }

  function fullNameOf(user) {
    return (user.f_name || '') + ' ' + (user.l_name || '');
  }

  function statusStyles(status) {
    switch ((status || '').toLowerCase()) {
      case 'active':
        return { bg: 'bg-green-100', text: 'text-green-700', label: 'Active' };
      case 'disable':
        return { bg: 'bg-red-100', text: 'text-red-700', label: 'Disabled' };
      case 'pending':
      default:
        return { bg: 'bg-amber/10', text: 'text-amber', label: 'Pending' };
    }
  }

  function userTypeStyles(userType) {
    switch ((userType || '').toLowerCase()) {
      case 'super_admin':
        return { bg: 'bg-pinetint', text: 'text-pine', label: 'Super Admin' };
      case 'admin':
      default:
        return { bg: 'bg-blue-50', text: 'text-blue-600', label: 'Admin' };
    }
  }


  /* =============================================================
     API HELPERS
  ============================================================== */
  function apiGet(params) {
    var url = USER_API_URL + '?' + new URLSearchParams(params).toString();
    return fetch(url, {
      method: 'GET',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(function (res) { return res.json(); });
  }

  function apiPost(payload) {
    return fetch(USER_API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(payload)
    }).then(function (res) { return res.json(); });
  }


  /* =============================================================
     CONFIRM MODAL WITH 10-SECOND COUNTDOWN
     -------------------------------------------------------------
     Grayed-out muna yung "Yes" button, may countdown number sa
     loob nito. Pag natapos yung countdown, magiging enabled at
     green (o yung ibinigay na kulay).
  ============================================================== */
  function confirmDangerAction(opts) {
    return new Promise(function (resolve) {
      if (typeof Swal === 'undefined') {
        resolve(window.confirm(opts.title || 'Are you sure?'));
        return;
      }

      var seconds = USER_CONFIRM_COUNTDOWN;
      var countdownTimer = null;

      Swal.fire({
        icon: 'warning',
        title: opts.title,
        html: opts.html || '',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonText: 'Yes (' + seconds + ')',
        confirmButtonColor: '#9ca3af',
        reverseButtons: true,
        allowOutsideClick: false,
        didOpen: function () {
          var btn = Swal.getConfirmButton();
          if (!btn) return;

          btn.disabled = true;

          countdownTimer = setInterval(function () {
            seconds -= 1;

            if (seconds <= 0) {
              clearInterval(countdownTimer);
              btn.disabled = false;
              btn.textContent = 'Yes';
              btn.style.backgroundColor = opts.confirmColor || '#dc2626';
            } else {
              btn.textContent = 'Yes (' + seconds + ')';
            }
          }, 1000);
        },
        willClose: function () {
          if (countdownTimer) clearInterval(countdownTimer);
        }
      }).then(function (result) {
        resolve(!!result.isConfirmed);
      });
    });
  }

  function toast(icon, title) {
    if (typeof Swal === 'undefined') return;
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: icon,
      title: title,
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
  }

  function alertError(message) {
    if (typeof Swal === 'undefined') {
      window.alert(message);
      return;
    }
    Swal.fire({ icon: 'error', title: 'Something went wrong', text: message });
  }


  /* =============================================================
     RENDER — USER LIST
  ============================================================== */
  function closeAllMenus() {
    list.querySelectorAll('.user-menu').forEach(function (m) {
      m.classList.add('hidden');
    });
    state.openMenuId = null;
  }

  function renderUserList(usersData) {
    list.innerHTML = '';

    if (!usersData || usersData.length === 0) {
      list.classList.add('hidden');
      if (emptyEl) {
        emptyEl.classList.remove('hidden');
        emptyEl.classList.add('flex');
      }
      return;
    }

    if (emptyEl) {
      emptyEl.classList.add('hidden');
      emptyEl.classList.remove('flex');
    }
    list.classList.remove('hidden');

    usersData.forEach(function (user) {
      list.appendChild(buildUserItem(user));
    });
  }

  function buildUserItem(user) {
    var statusStyle = statusStyles(user.status);
    var typeStyle   = userTypeStyles(user.user_type);

    var isSelf = state.currentUserId === parseInt(user.user_id, 10);

    // Edit button (dropdown trigger) — grayed out/disabled kapag
    // hindi super_admin ang naka-login, o kapag sarili niyang
    // account ang tinitingnan (iwas ma-lock-out sa sarili).
    var canManage = state.isSuperAdmin && !isSelf;

    var wrapper = document.createElement('div');
    wrapper.className =
      'user-item relative flex items-center gap-4 p-4 bg-surface border border-hairline rounded-xl hover:border-pine/40 hover:shadow-sm transition-all duration-200';
    wrapper.setAttribute('data-user-id', user.user_id);

    var nextStatus = (user.status || '').toLowerCase() === 'active' ? 'disable' : 'active';
    var toggleLabel = nextStatus === 'active' ? 'Enable' : 'Disable';
    var toggleIcon  = nextStatus === 'active' ? 'fa-solid fa-toggle-on' : 'fa-solid fa-toggle-off';

    wrapper.innerHTML =
      '<div class="w-12 h-12 rounded-full bg-pinetint text-pine flex items-center justify-center font-semibold text-sm shrink-0">' +
        escapeHtml(initialsOf(user)) +
      '</div>' +

      '<div class="flex-1 min-w-0">' +
        '<p class="text-sm font-semibold text-ink truncate">' + escapeHtml(user.username) + '</p>' +
        '<p class="text-sm text-inkmuted truncate">' + escapeHtml(user.gmail) + '</p>' +
        '<div class="flex items-center gap-2 mt-2">' +
          '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ' + statusStyle.bg + ' ' + statusStyle.text + '">' + statusStyle.label + '</span>' +
          '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ' + typeStyle.bg + ' ' + typeStyle.text + '">' + typeStyle.label + '</span>' +
        '</div>' +
      '</div>' +

      '<div class="relative shrink-0">' +
        '<button type="button" ' +
          'class="user-edit-btn inline-flex items-center gap-2 px-4 py-2 rounded-lg border text-sm font-medium transition-colors ' +
          (canManage
            ? 'bg-canvas border-hairline text-inkmuted hover:bg-pinetint hover:text-pine hover:border-pine/30 cursor-pointer'
            : 'bg-canvas border-hairline text-inkmuted/50 cursor-not-allowed opacity-50') +
          '" ' +
          (canManage ? 'data-action="toggle-menu"' : 'disabled title="' + (isSelf ? 'You cannot manage your own account here.' : 'Only a super admin can manage users.') + '"') +
        '>' +
          '<i class="fa-solid fa-pen text-xs"></i> Edit' +
        '</button>' +

        (canManage ?
          '<div class="user-menu hidden absolute right-0 mt-2 w-44 bg-surface border border-hairline rounded-xl shadow-lg overflow-hidden z-20">' +
            '<button type="button" data-action="toggle-status" data-target-status="' + nextStatus + '" ' +
              'class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-inkmuted hover:bg-canvas transition-colors">' +
              '<i class="' + toggleIcon + ' text-xs w-4"></i> ' + toggleLabel +
            '</button>' +
            '<button type="button" data-action="delete-user" ' +
              'class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors border-t border-hairline">' +
              '<i class="fa-solid fa-trash text-xs w-4"></i> Delete' +
            '</button>' +
          '</div>'
          : '') +
      '</div>';

    return wrapper;
  }


  /* =============================================================
     RENDER — PAGINATION
  ============================================================== */
  function renderPagination(totalPages, currentPage) {
    if (!pagination) return;

    pagination.innerHTML = '';

    if (totalPages <= 1) return;

    for (var p = 1; p <= totalPages; p++) {
      (function (p) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'page-btn w-9 h-9 rounded-lg text-sm font-medium transition-colors ' +
          (p === currentPage
            ? 'bg-pine text-white font-semibold shadow-sm hover:bg-pinedark'
            : 'bg-surface border border-hairline text-inkmuted hover:bg-canvas hover:border-[#C6D1C4]');
        btn.textContent = p;
        btn.setAttribute('data-page', p);
        btn.setAttribute('aria-current', p === currentPage ? 'true' : 'false');

        btn.addEventListener('click', function () {
          loadPage(p);
        });

        pagination.appendChild(btn);
      })(p);
    }
  }


  /* =============================================================
     LOAD A PAGE OF USERS (initial load + pagination click +
     realtime refresh)
  ============================================================== */
  function loadPage(page, silent) {
    if (!silent && loadingEl) {
      loadingEl.classList.remove('hidden');
      list.classList.add('hidden');
      if (emptyEl) emptyEl.classList.add('hidden');
    }

    apiGet({ action: 'list', page: page, per_page: USER_PER_PAGE })
      .then(function (res) {
        if (loadingEl) loadingEl.classList.add('hidden');

        if (!res || !res.success) {
          console.error('Failed to load users:', res && res.message);
          return;
        }

        state.currentPage = res.page;

        renderUserList(res.data);
        renderPagination(res.total_pages, res.page);
      })
      .catch(function (err) {
        if (loadingEl) loadingEl.classList.add('hidden');
        console.error('Failed to load users:', err);
      });
  }


  /* =============================================================
     REALTIME REFRESH (light polling) — kinukuha lang ulit yung
     kasalukuyang page nang tahimik, walang loading spinner/
     walang flicker, para lumabas agad kung may ibang admin na
     nag-add/nag-disable/nag-delete ng account.
  ============================================================== */
  function startRealtimeRefresh() {
    if (state.pollTimer) return;

    state.pollTimer = setInterval(function () {
      // Huwag mag-refresh habang may bukas na dropdown/modal, para
      // hindi biglang mawala yung kinakausap na menu ng admin.
      if (state.openMenuId !== null) return;
      if (document.querySelector('.swal2-container')) return;

      loadPage(state.currentPage, true);
    }, USER_POLL_INTERVAL_MS);
  }


  /* =============================================================
     ACTIONS — enable/disable, delete
  ============================================================== */
  function toggleUserStatus(userId, targetStatus, username) {
    var isEnable = targetStatus === 'active';

    confirmDangerAction({
      title: 'Are you sure you want to ' + (isEnable ? 'enable' : 'disable') + ' this account?',
      html: '<p class="text-sm text-gray-500">' + escapeHtml(username) + '</p>',
      confirmColor: isEnable ? '#16a34a' : '#dc2626'
    }).then(function (confirmed) {
      if (!confirmed) return;

      apiPost({ action: 'update_status', user_id: userId, status: targetStatus })
        .then(function (res) {
          if (res && res.success) {
            toast('success', isEnable ? 'Account enabled' : 'Account disabled');
            loadPage(state.currentPage, true);
          } else {
            alertError((res && res.message) || 'Please try again.');
          }
        })
        .catch(function (err) {
          console.error('Failed to update status:', err);
          alertError('Please check your connection and try again.');
        });
    });
  }

  function deleteUser(userId, username) {
    confirmDangerAction({
      title: 'Are you sure you want to delete this account?',
      html: '<p class="text-sm text-gray-500">' + escapeHtml(username) + ' — this cannot be undone.</p>',
      confirmColor: '#dc2626'
    }).then(function (confirmed) {
      if (!confirmed) return;

      apiPost({ action: 'delete', user_id: userId })
        .then(function (res) {
          if (res && res.success) {
            toast('success', 'Account deleted');
            loadPage(state.currentPage, true);
          } else {
            alertError((res && res.message) || 'Please try again.');
          }
        })
        .catch(function (err) {
          console.error('Failed to delete user:', err);
          alertError('Please check your connection and try again.');
        });
    });
  }



  /* =============================================================
     EVENT DELEGATION — Edit button, dropdown menu items
  ============================================================== */
  list.addEventListener('click', function (event) {
    var toggleBtn = event.target.closest('[data-action="toggle-menu"]');

    if (toggleBtn) {
      var item = toggleBtn.closest('.user-item');
      var menu = item ? item.querySelector('.user-menu') : null;
      var userId = item ? item.getAttribute('data-user-id') : null;

      var wasOpen = menu && !menu.classList.contains('hidden');
      closeAllMenus();

      if (menu && !wasOpen) {
        menu.classList.remove('hidden');
        state.openMenuId = userId;
      }

      return;
    }

    var statusBtn = event.target.closest('[data-action="toggle-status"]');

    if (statusBtn) {
      var statusItem = statusBtn.closest('.user-item');
      var statusUserId = statusItem ? statusItem.getAttribute('data-user-id') : null;
      var username = statusItem ? statusItem.querySelector('p.font-semibold').textContent : '';
      closeAllMenus();

      if (statusUserId) {
        toggleUserStatus(parseInt(statusUserId, 10), statusBtn.getAttribute('data-target-status'), username);
      }
      return;
    }

    var deleteBtn = event.target.closest('[data-action="delete-user"]');

    if (deleteBtn) {
      var deleteItem = deleteBtn.closest('.user-item');
      var deleteUserId = deleteItem ? deleteItem.getAttribute('data-user-id') : null;
      var deleteUsername = deleteItem ? deleteItem.querySelector('p.font-semibold').textContent : '';
      closeAllMenus();

      if (deleteUserId) {
        deleteUser(parseInt(deleteUserId, 10), deleteUsername);
      }
      return;
    }
  });

  // Isara ang dropdown pag nag-click sa labas nito.
  document.addEventListener('click', function (event) {
    if (!event.target.closest('.user-item')) {
      closeAllMenus();
    }
  });

  /* =============================================================
     INIT — unang pag-load ng page 1, saka simulan ang polling
  ============================================================== */
  loadPage(1);
  startRealtimeRefresh();
}
