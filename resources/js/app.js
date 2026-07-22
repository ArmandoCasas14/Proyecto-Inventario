

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // Escuchar el evento 'submit' en todo el documento
    document.addEventListener('submit', (e) => {
        const form = e.target;

        // Verificar si el formulario tiene el atributo data-confirm
        if (form.hasAttribute('data-confirm')) {
            e.preventDefault(); // Detener el envío del formulario

            const message = form.getAttribute('data-confirm') || '¿Estás seguro de realizar esta acción?';
            const title = form.getAttribute('data-confirm-title') || '¿Estás seguro?';
            const buttonText = form.getAttribute('data-confirm-button') || 'Sí, continuar';

            Swal.fire({
                title: title,
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5', // Color índigo predeterminado
                cancelButtonColor: '#6b7280',  // Color gris cancel
                confirmButtonText: buttonText,
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Enviar el formulario tras la confirmación
                }
            });
        }
    });
});