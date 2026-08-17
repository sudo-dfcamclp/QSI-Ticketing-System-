document.addEventListener('DOMContentLoaded', function () {

    const form      = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    /* =========================================================
       ATTACHMENT HANDLING
       -----------------------------------------------------------
       - Click sa attachmentArea -> binubuksan yung file picker
       - Ctrl+V habang naka-focus sa attachmentArea -> kinukuha
         yung na-copy na image (hal. screenshot) at itinatakda
         bilang value ng file input gamit ang DataTransfer
       - Preview: filename + size, at thumbnail kung image
       - "X" button -> alisin/i-reset ang napiling attachment
    ========================================================== */
    const attachmentArea    = document.getElementById('attachmentArea');
    const attachmentInput   = document.getElementById('attachment');
    const attachmentEmpty   = document.getElementById('attachmentEmpty');
    const attachmentPreview = document.getElementById('attachmentPreview');
    const attachmentIcon    = document.getElementById('attachmentIcon');
    const attachmentName    = document.getElementById('attachmentName');
    const attachmentSize    = document.getElementById('attachmentSize');
    const removeAttachment  = document.getElementById('removeAttachment');
    const imagePreviewWrap  = document.getElementById('imagePreviewWrapper');
    const imagePreview      = document.getElementById('imagePreview');

    // Dapat tumugma ito sa "accept" attribute sa forms.php AT sa
    // whitelist na sinusuri rin sa form-control.php (server-side
    // ang totoong gate — huwag umasa sa client-side check lang).
    const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg'];
    const MAX_FILE_SIZE_BYTES = 10 * 1024 * 1024; // 10MB

    function fileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function iconClassFor(ext) {
        if (['png', 'jpg', 'jpeg'].includes(ext)) return 'fa-solid fa-image';
        if (ext === 'pdf') return 'fa-solid fa-file-pdf';
        if (['doc', 'docx'].includes(ext)) return 'fa-solid fa-file-word';
        if (['ppt', 'pptx'].includes(ext)) return 'fa-solid fa-file-powerpoint';
        if (['xls', 'xlsx'].includes(ext)) return 'fa-solid fa-file-excel';
        return 'fa-solid fa-file';
    }

    function showAttachmentPreview(file) {
        attachmentEmpty.classList.add('hidden');
        attachmentPreview.classList.remove('hidden');

        attachmentName.textContent = file.name;
        attachmentSize.textContent = formatFileSize(file.size);

        var ext = fileExtension(file.name);
        attachmentIcon.innerHTML = '<i class="' + iconClassFor(ext) + ' text-pine text-xs"></i>';

        if (file.type.indexOf('image/') === 0) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreviewWrap.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreviewWrap.classList.add('hidden');
            imagePreview.src = '';
        }
    }

    function resetAttachment() {
        attachmentInput.value = '';
        attachmentEmpty.classList.remove('hidden');
        attachmentPreview.classList.add('hidden');
        imagePreviewWrap.classList.add('hidden');
        imagePreview.src = '';
        attachmentName.textContent = '';
        attachmentSize.textContent = '';
    }

    function handleSelectedFile(file) {
        if (!file) return;

        var ext = fileExtension(file.name);

        if (ALLOWED_EXTENSIONS.indexOf(ext) === -1) {
            Swal.fire({
                icon: 'error',
                title: 'Unsupported file type',
                text: 'Allowed types: PDF, Word, Excel, PowerPoint, or image (PNG/JPG).',
                confirmButtonColor: '#0a5d3c'
            });
            resetAttachment();
            return;
        }

        if (file.size > MAX_FILE_SIZE_BYTES) {
            Swal.fire({
                icon: 'error',
                title: 'File too large',
                text: 'Maximum attachment size is 10MB.',
                confirmButtonColor: '#0a5d3c'
            });
            resetAttachment();
            return;
        }

        showAttachmentPreview(file);
    }

    // ---------- Click sa buong area -> buksan file picker ----------
    attachmentArea.addEventListener('click', function (e) {
        if (e.target.closest('#removeAttachment')) return; // iwas double-trigger
        attachmentInput.click();
    });

    // ---------- Normal na pag-browse/pag-pili ng file ----------
    attachmentInput.addEventListener('change', function () {
        if (attachmentInput.files && attachmentInput.files[0]) {
            handleSelectedFile(attachmentInput.files[0]);
        }
    });

    // ---------- Ctrl+V paste ng image (hal. screenshot) ----------
    attachmentArea.addEventListener('paste', function (e) {
        var items = (e.clipboardData || window.clipboardData).items;
        if (!items) return;

        for (var i = 0; i < items.length; i++) {
            if (items[i].type.indexOf('image') !== -1) {
                var blob = items[i].getAsFile();
                if (!blob) continue;

                // Bigyan ng pangalan ang pasted image — walang
                // filename by default ang clipboard blob.
                var ext = (blob.type.split('/')[1] || 'png');
                var pastedFile = new File(
                    [blob],
                    'pasted-image-' + Date.now() + '.' + ext,
                    { type: blob.type }
                );

                // I-set sa <input type="file"> gamit ang DataTransfer
                // para masama ito sa FormData pag nag-submit.
                var dataTransfer = new DataTransfer();
                dataTransfer.items.add(pastedFile);
                attachmentInput.files = dataTransfer.files;

                handleSelectedFile(pastedFile);
                e.preventDefault();
                break;
            }
        }
    });

    // ---------- Alisin ang attachment ----------
    removeAttachment.addEventListener('click', function (e) {
        e.stopPropagation();
        resetAttachment();
    });

    /* =========================================================
       SUBMIT TICKET (REALTIME / AJAX)
       -----------------------------------------------------------
       FormData na kasama — dahil name="attachment" na ang file
       input, kasama na ito automatic sa multipart/form-data body
       kapag may napiling/na-paste na file.
    ========================================================== */
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const originalBtnHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Submitting...';

        const formData = new FormData(form);

        try {
            const response = await fetch('control/form-control.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Ticket Submitted',
                    text: result.message || 'Your ticket has been submitted.',
                    confirmButtonColor: '#0a5d3c'
                });

                // Clear the form after the user acknowledges the alert
                form.reset();
                resetAttachment();
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: result.message || 'Something went wrong. Please try again.',
                    confirmButtonColor: '#0a5d3c'
                });
            }
        } catch (error) {
            await Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Could not reach the server. Please try again.',
                confirmButtonColor: '#0a5d3c'
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;
        }
    });

});