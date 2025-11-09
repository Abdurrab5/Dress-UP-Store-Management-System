document.addEventListener('DOMContentLoaded', function () {
    const authContainer = document.querySelector('.auth-container');
    const showSignup = document.getElementById('showSignup');
    const showLogin = document.getElementById('showLogin');
    const toggleForm = document.getElementById('toggleForm');
    const loginToggle = document.getElementById('loginToggle');
    const signupToggle = document.getElementById('signupToggle');
    const confirmToggle = document.getElementById('confirmToggle');

    const loginPassword = document.getElementById('loginPassword');
    const signupPassword = document.getElementById('signupPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    // Toggle password visibility
    function togglePasswordVisibility(toggleBtn, inputField) {
        toggleBtn.addEventListener('click', function () {
            const icon = toggleBtn.querySelector('i');
            if (inputField.type === 'password') {
                inputField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                inputField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }

    togglePasswordVisibility(loginToggle, loginPassword);
    togglePasswordVisibility(signupToggle, signupPassword);
    togglePasswordVisibility(confirmToggle, confirmPassword);

    // Slide between forms
    showSignup.addEventListener('click', function (e) {
        e.preventDefault();
        authContainer.classList.add('show-signup');
    });

    showLogin.addEventListener('click', function (e) {
        e.preventDefault();
        authContainer.classList.remove('show-signup');
    });

    toggleForm.addEventListener('click', function (e) {
        e.preventDefault();
        authContainer.classList.remove('show-signup');
    });

    // Signup validation
    const signupForm = document.getElementById('signupForm');
    signupForm.addEventListener('submit', function (e) {
        let isValid = true;
        e.preventDefault();

        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const email = document.getElementById('signupEmail');
        const password = document.getElementById('signupPassword');
        const confirm = document.getElementById('confirmPassword');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function showError(input, messageEl, condition) {
            if (condition) {
                messageEl.style.display = 'block';
                isValid = false;
            } else {
                messageEl.style.display = 'none';
            }
        }

        showError(firstName, firstName.nextElementSibling, !firstName.value.trim());
        showError(lastName, lastName.nextElementSibling, !lastName.value.trim());
        showError(email, email.nextElementSibling, !emailRegex.test(email.value));
        showError(password, password.nextElementSibling.nextElementSibling, password.value.length < 8);
        showError(confirm, confirm.nextElementSibling, password.value !== confirm.value);

        if (isValid) signupForm.submit();
    });
});
