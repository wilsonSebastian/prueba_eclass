document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', function () {
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                sidebar.style.width = '250px';
            } else {
                sidebar.classList.add('collapsed');
                sidebar.style.width = '0';
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        // Seleccionar todos los botones con clase "show-coursemates"
        const showCoursematesButtons = document.querySelectorAll('.show-coursemates');

        // Añadir un event listener a cada botón
        showCoursematesButtons.forEach(button => {
            button.addEventListener('click', function () {
                const courseId = button.getAttribute('data-course-id');
                const coursematesList = document.getElementById(`coursemates-${courseId}`);
                
                // Mostrar u ocultar la lista de compañeros de curso
                if (coursematesList.style.display === 'none') {
                    coursematesList.style.display = 'block';
                } else {
                    coursematesList.style.display = 'none';
                }
            });
        });
    });
