
document.addEventListener('DOMContentLoaded', () => {

    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    if (!registerForm || !submitBtn) {
        return;
    }


    // -------------------------------------------------------
    // Password Toggle
    // -------------------------------------------------------

    window.togglePassword = function (inputId, button) {

        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (!input || !icon) {
            return;
        }

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    };


    // -------------------------------------------------------
    // Registration Form
    // -------------------------------------------------------

    registerForm.addEventListener('submit', async (event) => {

        event.preventDefault();


        // ---------------------------------------------------
        // Get Form Values
        // ---------------------------------------------------

        const formData = new FormData(registerForm);

        const f_name = formData.get('f_name')?.trim() || '';
        const l_name = formData.get('l_name')?.trim() || '';
        const username = formData.get('username')?.trim() || '';
        const gmail = formData.get('gmail')?.trim() || '';
        const password = formData.get('password') || '';
        const confirmPassword = formData.get('confirm_password') || '';


        // ---------------------------------------------------
        // Client-Side Validation
        // ---------------------------------------------------

        if (
            f_name === '' ||
            l_name === '' ||
            username === '' ||
            gmail === '' ||
            password === '' ||
            confirmPassword === ''
        ) {

            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                text: 'Please complete all fields before registering.',
                confirmButtonColor: '#0a5d3c'
            });

            return;
        }


        // ---------------------------------------------------
        // Password Confirmation
        // ---------------------------------------------------

        if (password !== confirmPassword) {

            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'The passwords do not match.',
                confirmButtonColor: '#0a5d3c'
            });

            return;
        }


        // ---------------------------------------------------
        // Disable Button
        // ---------------------------------------------------

        submitBtn.disabled = true;

        submitBtn.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin mr-2"></i>
            Registering...
        `;


        try {

            // ------------------------------------------------
            // Send API Request
            // ------------------------------------------------

            const response = await fetch(
                'control/register-control.php',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json'
                    },

                    body: JSON.stringify({
                        f_name: f_name,
                        l_name: l_name,
                        username: username,
                        gmail: gmail,
                        password: password,
                        confirm_password: confirmPassword
                    })
                }
            );


            // ------------------------------------------------
            // Parse Response
            // ------------------------------------------------

            const result = await response.json();


            // ------------------------------------------------
            // Registration Failed
            // ------------------------------------------------

            if (!response.ok || result.status !== 'success') {

                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: result.message || 'Unable to register the account.',
                    confirmButtonColor: '#0a5d3c'
                });

                return;
            }


            // ------------------------------------------------
            // Registration Successful
            // ------------------------------------------------

            await Swal.fire({
                icon: 'success',
                title: 'Registration Complete',
                text: result.message || 'Your account has been successfully created.',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });


            // ------------------------------------------------
            // Redirect To Login
            // ------------------------------------------------

            window.location.href = 'login.php';


        } catch (error) {

            console.error('Registration Error:', error);

            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Unable to connect to the server. Please try again.',
                confirmButtonColor: '#0a5d3c'
            });


        } finally {

            // ------------------------------------------------
            // Re-enable Button
            // ------------------------------------------------

            submitBtn.disabled = false;

            submitBtn.innerHTML = `
                <i class="fa-solid fa-user-plus mr-2"></i>
                Register
            `;
        }

    });

});

