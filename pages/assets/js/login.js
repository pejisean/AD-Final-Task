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
 * Handles the login form submission and validation.
 * @returns {boolean} - Always false to prevent default form submission.
 */
function handleLogin() {
    clearErrorMessages(); // Clear previous messages

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

    // Retrieve registered users from localStorage
    const registeredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];

    const foundUser = registeredUsers.find(user => user.codename === codename);

    if (!foundUser) {
        displayFormMessage('Codename not found. Please sign up first.', 'error');
        // No automatic redirect here, user explicitly clicks "Sign Up Here"
    } else if (foundUser.password !== password) { // In a real app, compare hashed passwords!
        displayFormMessage('Incorrect password. Please try again.', 'error');
    } else {
        localStorage.setItem('loggedInCodename', codename); // Store the logged-in codename

        displayFormMessage('Login successful! Redirecting to home...', 'success');
        // Redirect to index.php after successful login
        setTimeout(() => {
            // Adjust path if your index.php is not directly in the parent directory of pages/
            window.location.href = '../index.php';
        }, 1500);
    }

    return false; // Prevent actual form submission, handled by JS
}