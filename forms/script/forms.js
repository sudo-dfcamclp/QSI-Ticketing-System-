document.addEventListener('DOMContentLoaded', function () {

    const form      = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    /* =========================================================
       SUBMIT TICKET (REALTIME / AJAX)
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