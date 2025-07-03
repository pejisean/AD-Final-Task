function clearErrorMessages() {
    document.querySelectorAll('.input-error-message').forEach(el => el.textContent = '');
    document.getElementById('form-message').textContent = '';
    document.getElementById('form-message').className = 'info-message';
}

/**
 * @param {string} elementId
 * @param {string} message
 */
function displayInputError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.color = '#e74c3c';
    }
}

/**
 * @param {string} message
 * @param {string} type
 */
function displayFormMessage(message, type) {
    const formMessageElement = document.getElementById('form-message');
    if (formMessageElement) {
        formMessageElement.textContent = message;
        formMessageElement.className = 'info-message';
        if (type === 'success') {
            formMessageElement.style.color = '#2ecc71';
        } else if (type === 'error') {
            formMessageElement.style.color = '#e74c3c';
        } else {
            formMessageElement.style.color = '#3498db';
        }
    }
}

/**
 * @returns {boolean}
 */
function validateSignupForm() {
    clearErrorMessages();

    const codename = document.getElementById('codename').value.trim();
    const gender = document.getElementById('gender').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    let isValid = true;

    if (codename === '') {
        displayInputError('codename-error', 'Codename is required.');
        isValid = false;
    } else if (codename.length < 3) {
        displayInputError('codename-error', 'Codename must be at least 3 characters.');
        isValid = false;
    } else if (!/^[a-zA-Z0-9_]+$/.test(codename)) {
        displayInputError('codename-error', 'Codename can only contain letters, numbers, and underscores.');
        isValid = false;
    }

    if (gender === '') {
        displayInputError('gender-error', 'Please select your gender.');
        isValid = false;
    }

    if (password === '') {
        displayInputError('password-error', 'Password is required.');
        isValid = false;
    } else if (password.length < 6) {
        displayInputError('password-error', 'Password must be at least 6 characters long.');
        isValid = false;
    } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
        displayInputError('password-error', 'Password must include uppercase, lowercase, and a number.');
        isValid = false;
    }

    if (confirmPassword === '') {
        displayInputError('confirm-password-error', 'Confirm password is required.');
        isValid = false;
    } else if (password !== confirmPassword) {
        displayInputError('confirm-password-error', 'Passwords do not match!');
        isValid = false;
    }

    if (isValid) {

        const users = JSON.parse(localStorage.getItem('registeredUsers')) || [];
        const userExists = users.some(user => user.codename === codename);

        if (userExists) {
            displayFormMessage('This codename is already taken. Please choose another.', 'error');
            isValid = false;
        } else {
            users.push({ codename: codename, password: password });
            localStorage.setItem('registeredUsers', JSON.stringify(users));
            displayFormMessage('Account created successfully! Redirecting to login...', 'success');

            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);
        }
    } else {
        displayFormMessage('Please correct the errors above.', 'error');
    }

    return false;
}