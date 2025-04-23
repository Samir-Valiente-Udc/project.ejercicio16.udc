document.addEventListener('DOMContentLoaded', function() {
    // Validación general de formularios
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            // Validación específica para contraseñas coincidentes
            if (form.querySelector('#password') && form.querySelector('#confirm_password')) {
                const password = form.querySelector('#password').value;
                const confirmPassword = form.querySelector('#confirm_password').value;
                
                if (password !== confirmPassword) {
                    isValid = false;
                    form.querySelector('#confirm_password').classList.add('is-invalid');
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos correctamente.');
            }
        });
    });
    
    // Validación en tiempo real
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
});