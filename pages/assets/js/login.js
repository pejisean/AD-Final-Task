/**
 * Display input error message
 * @param {string} elementId - The ID of the error element
 * @param {string} message - The error message to display
 */
function displayInputError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

/**
 * Display form message
 * @param {string} message - The message to display
 * @param {string} type - The type of message ('success' or 'error')
 */
function displayFormMessage(message, type) {
    const messageElement = document.getElementById('form-message');
    if (messageElement) {
        messageElement.textContent = message;
        messageElement.className = `info-message ${type}`;
        messageElement.style.display = 'block';
    }
}

/**
 * Clear all error messages
 */
function clearErrorMessages() {
    const errorElements = document.querySelectorAll('.input-error-message');
    errorElements.forEach(element => {
        element.textContent = '';
        element.style.display = 'none';
    });
    
    const formMessage = document.getElementById('form-message');
    if (formMessage) {
        formMessage.style.display = 'none';
    }
}

/**
 * Handle login form submission
 * @returns {boolean}
 */
function handleLogin() {
    clearErrorMessages();

    const codename = document.getElementById('codename').value.trim();
    const password = document.getElementById('password').value;

    // Debug logging
    console.log('Login attempt:', { codename, passwordLength: password.length });

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

    // Send login request to server
    fetch('../handlers/login.handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            codename: codename,
            password: password
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text(); // Use text() first to see raw response
    })
    .then(text => {
        console.log('Raw response:', text);
        try {
            const data = JSON.parse(text);
            console.log('Parsed response:', data);
            
            if (data.success) {
                displayFormMessage('Login successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = '../index.php';
                }, 1500);
            } else {
                displayFormMessage(data.message, 'error');
                
                // Show debug info if available
                if (data.debug) {
                    console.log('Debug info:', data.debug);
                }
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            console.log('Response was not valid JSON:', text);
            displayFormMessage('Server error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        displayFormMessage('An error occurred. Please try again.', 'error');
    });

    return false;
}