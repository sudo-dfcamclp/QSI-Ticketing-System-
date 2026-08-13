
//-----------------------------------------------------------
// LOGIN FORM + PASSWORD TOGGLE + API LOGIN
//-----------------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.querySelector('#loginForm');
    const usernameInput = document.querySelector('#username');
    const passwordInput = document.querySelector('#password');
    const submitBtn = loginForm
        ? loginForm.querySelector('button[type="submit"]')
        : null;

    // -------------------------------------------------------
    // Toggle Password
    // -------------------------------------------------------

    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function () {

            const input = this.closest('.relative')?.querySelector('input');
            const icon = this.querySelector('i');

            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });

    // -------------------------------------------------------
    // Login API
    // -------------------------------------------------------

    if (loginForm && usernameInput && passwordInput && submitBtn) {

        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const username = usernameInput.value.trim();
            const password = passwordInput.value;

            if (!username || !password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Login',
                    text: 'Please enter your username and password.',
                    confirmButtonColor: '#0a5d3c'
                });
                return;
            }

            const originalBtnText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Logging in...';

            try {

                const response = await fetch('control/login-control.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            username: username,
                            password: password
                        })
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }

                const result = await response.json();

                // ---------------------------------------------------
                // SUCCESS
                // ---------------------------------------------------

                if (result.status === 'success') {

                    submitBtn.innerHTML =
                        '<i class="fa-solid fa-check mr-2"></i> Success!';

                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: result.message || 'Welcome!',
                        showConfirmButton: false,
                        timer: 1200
                    }).then(() => {

                        window.location.href =
                            result.redirect || 'dashboard.php';

                    });

                    return;
                }

                // ---------------------------------------------------
                // ERROR
                // ---------------------------------------------------

                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: result.message || 'Invalid username or password.',
                    confirmButtonColor: '#0a5d3c'
                });

                resetButton(submitBtn, originalBtnText);

            } catch (error) {

                console.error('Login error:', error);

                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    text: 'Unable to connect to the login server. Please try again.',
                    confirmButtonColor: '#0a5d3c'
                });

                resetButton(submitBtn, originalBtnText);
            }
        });
    }

    // -------------------------------------------------------
    // Reset Button
    // -------------------------------------------------------

    function resetButton(btn, text) {
        btn.disabled = false;
        btn.innerHTML = text;
    }

});

