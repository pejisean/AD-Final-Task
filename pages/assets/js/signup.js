function clearErrorMessages() {
    const errorMessages = document.querySelectorAll('.input-error-message');
    errorMessages.forEach(msg => msg.textContent = '');
}

/**
 * @param {string} elementId
 * @param {string} message
 */
function displayInputError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
    }
}

/**
 * @param {string} message
 * @param {string} type
 */
function displayFormMessage(message, type) {
    const messageElement = document.getElementById('form-message');
    if (messageElement) {
        messageElement.textContent = message;
        messageElement.className = type === 'success' ? 'success-message' : 'error-message';
    }
}

/**
 * Validate signup form on client side
 * @returns {boolean}
 */
function validateSignupForm() {
    clearErrorMessages();

    const codename = document.getElementById('codename').value.trim();
    const email = document.getElementById('email').value.trim();
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

    return isValid;
}

/**
 * Handle signup form submission
 * @returns {boolean}
 */
function handleSignup() {
    console.log('handleSignup() called');
    
    // First validate the form
    if (!validateSignupForm()) {
        console.log('Form validation failed');
        displayFormMessage('Please correct the errors above.', 'error');
        return false;
    }

    console.log('Form validation passed');

    const submitButton = document.querySelector('.signup-button');
    const originalText = submitButton.textContent;
    submitButton.textContent = 'Creating Account...';
    submitButton.disabled = true;

    const formData = {
        username: document.getElementById('codename').value.trim(),
        email: document.getElementById('email').value.trim(),
        gender: document.getElementById('gender').value,
        password: document.getElementById('password').value
    };

    console.log('Sending data:', formData);

    fetch('../handlers/signup.handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response received:', response.status, response.statusText);
        
        // Check if response is ok
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        // Get response as text first to check if it's JSON
        return response.text();
    })
    .then(text => {
        console.log('Raw response:', text);
        
        try {
            const data = JSON.parse(text);
            console.log('Parsed response data:', data);
            
            if (data.success) {
                displayFormMessage('Account created successfully! Redirecting to login...', 'success');
                
                // Clear the form
                document.querySelector('.signup-form').reset();
                
                // Redirect to login page after 2 seconds
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            } else {
                displayFormMessage(data.message || 'Registration failed', 'error');
            }
        } catch (parseError) {
            console.error('JSON parse error:', parseError);
            console.error('Response was not JSON:', text);
            displayFormMessage('Server error. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        displayFormMessage('Network error. Please try again.', 'error');
    })
    .finally(() => {
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    });

    return false; // Prevent form submission
}