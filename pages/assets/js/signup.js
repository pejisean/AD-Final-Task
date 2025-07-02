/**
 * Clears all error messages displayed on the form.
 */
function clearErrorMessages() {
    document.querySelectorAll('.input-error-message').forEach(el => el.textContent = '');
    document.getElementById('form-message').textContent = '';
    document.getElementById('form-message').className = 'info-message'; // Reset class
}

/**
 * Displays a specific error message for an input field.
 * @param {string} elementId - The ID of the error message paragraph.
 * @param {string} message - The error message to display.
 */
function displayInputError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.color = '#e74c3c'; // Red for error
    }
}

/**
 * Displays a general message for the form (success/error/info).
 * @param {string} message - The message to display.
 * @param {string} type - The type of message ('success', 'error', 'info').
 */
function displayFormMessage(message, type) {
    const formMessageElement = document.getElementById('form-message');
    if (formMessageElement) {
        formMessageElement.textContent = message;
        formMessageElement.className = 'info-message'; // Reset to default
        if (type === 'success') {
            formMessageElement.style.color = '#2ecc71'; // Green
        } else if (type === 'error') {
            formMessageElement.style.color = '#e74c3c'; // Red
        } else {
            formMessageElement.style.color = '#3498db'; // Blue for info
        }
    }
}

/**
 * Validates the signup form fields.
 * @returns {boolean} - True if all fields are valid, false otherwise.
 */
function validateSignupForm() {
    clearErrorMessages(); // Clear previous messages

    const codename = document.getElementById('codename').value.trim();
    const gender = document.getElementById('gender').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    let isValid = true;

    // Codename validation
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

    // Gender validation
    if (gender === '') {
        displayInputError('gender-error', 'Please select your gender.');
        isValid = false;
    }

    // Password validation
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

    // Confirm Password validation
    if (confirmPassword === '') {
        displayInputError('confirm-password-error', 'Confirm password is required.');
        isValid = false;
    } else if (password !== confirmPassword) {
        displayInputError('confirm-password-error', 'Passwords do not match!');
        isValid = false;
    }

    if (isValid) {
        // Simulate successful signup
        // In a real application, you would send this data to a server for registration.
        // For this demo, we'll store a dummy user in localStorage.
        const users = JSON.parse(localStorage.getItem('registeredUsers')) || [];
        const userExists = users.some(user => user.codename === codename);

        if (userExists) {
            displayFormMessage('This codename is already taken. Please choose another.', 'error');
            isValid = false;
        } else {
            users.push({ codename: codename, password: password }); // In real app, hash password!
            localStorage.setItem('registeredUsers', JSON.stringify(users));
            displayFormMessage('Account created successfully! Redirecting to login...', 'success');
            // Redirect to login.php after successful signup
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);
        }
    } else {
        displayFormMessage('Please correct the errors above.', 'error');
    }

    return false; // Prevent actual form submission, handled by JS
}