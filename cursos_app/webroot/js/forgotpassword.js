document.addEventListener('DOMContentLoaded', function () {
    const resetPasswordForm = document.getElementById('resetPasswordForm');
    const notification = document.getElementById('notification');

    resetPasswordForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Evita que el formulario se envíe

        // Muestra la notificación personalizada
        notification.style.display = 'block';

        // Espera 5 segundos para mostrar la notificación y luego redirige al login
        setTimeout(() => {
            notification.style.display = 'none';
            window.location.href = '/users/login'; // Redirige a la página de login
        }, 5000); // 5 segundos de espera
    });
});
