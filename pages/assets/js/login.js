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
 *
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
 *
 * @returns {boolean}
 */
function handleLogin() {
    clearErrorMessages();

    const codename = document.getElementById('codename').value.trim();
    const password = document.getElementById('password').value;

    let isValid = true;

    if (codename === '') {
        displayInputError('codename-error', 'Codename is required.');
        isValid = false;
    }
    if (password === '') {
        displayInputError('password-error', 'Password is required.');
        isValid = false;
    }

    if (!isValid) {
        displayFormMessage('Please fill in all required fields.', 'error');
        return false;
    }

    const registeredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];

    const foundUser = registeredUsers.find(user => user.codename === codename);

    if (!foundUser) {
        displayFormMessage('Codename not found. Please sign up first.', 'error');
    } else if (foundUser.password !== password) {
        displayFormMessage('Incorrect password. Please try again.', 'error');
    } else {
        localStorage.setItem('loggedInCodename', codename);

        displayFormMessage('Login successful! Redirecting to home...', 'success');
        setTimeout(() => {
            window.location.href = '../index.php';
        }, 1500);
    }

    return false;
}