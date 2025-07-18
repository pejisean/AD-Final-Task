window.addEventListener('load', function () {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('hidden');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Prevent multiple initializations
    if (window.scriptInitialized) {
        console.log('Script already initialized, skipping...');
        return;
    }
    window.scriptInitialized = true;

    // Check authentication from server first
    fetch('handlers/check-session.handler.php', {
        credentials: 'same-origin'
    })
        .then(response => response.json())
        .then(data => {
            const loginSignupLink = document.getElementById('login-signup-link');
            if (!loginSignupLink) return;

            if (data.success && data.logged_in && data.user) {
                // User is logged in
                updateUIForLoggedInUser(data.user.username, loginSignupLink);
                localStorage.setItem('loggedInCodename', data.user.username);
            } else {
                // User is not logged in
                localStorage.removeItem('loggedInCodename');
                updateUIForLoggedOutUser(loginSignupLink);
            }
        })
        .catch(error => {
            console.error('Session check failed:', error);
            // Fallback to localStorage
            const loggedInCodename = localStorage.getItem('loggedInCodename');
            const loginSignupLink = document.getElementById('login-signup-link');
            if (loginSignupLink) {
                if (loggedInCodename) {
                    updateUIForLoggedInUser(loggedInCodename, loginSignupLink);
                } else {
                    updateUIForLoggedOutUser(loginSignupLink);
                }
            }
        });

    // Initialize sorting only once
    initializeSorting();

    // Initialize navigation
    initializeNavigation();

    // Update cart count only once on page load
    updateCartIconCount();
});

function initializeSorting() {
    const mainSortDropdown = document.querySelector('#sort-by-main');

    if (mainSortDropdown && !mainSortDropdown.hasAttribute('data-initialized')) {
        mainSortDropdown.setAttribute('data-initialized', 'true');

        const newArrivalsGrid = document.querySelector('#new-arrivals-grid');
        const topSellersGrid = document.querySelector('#top-sellers-grid');

        if (newArrivalsGrid && topSellersGrid) {
            const allCards = [
                ...newArrivalsGrid.querySelectorAll('.product-card'),
                ...topSellersGrid.querySelectorAll('.product-card')
            ];

            const originalOrder = [...allCards];
            const newArrivalsCapacity = newArrivalsGrid.children.length;

            mainSortDropdown.addEventListener('change', function () {
                const sortBy = this.value;
                let sortedProducts;

                const listToSort = [...originalOrder];

                switch (sortBy) {
                    case 'price-asc':
                        sortedProducts = listToSort.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
                        break;
                    case 'price-desc':
                        sortedProducts = listToSort.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
                        break;
                    default:
                        sortedProducts = originalOrder;
                        break;
                }

                newArrivalsGrid.innerHTML = '';
                topSellersGrid.innerHTML = '';

                sortedProducts.forEach((product, index) => {
                    if (index < newArrivalsCapacity) {
                        newArrivalsGrid.appendChild(product);
                    } else {
                        topSellersGrid.appendChild(product);
                    }
                });
            });
        }
    }
}

function initializeNavigation() {
    try {
        const currentPage = window.location.pathname.split('/').pop();
        if (currentPage) {
            const navLinks = document.querySelectorAll('.main-nav a');
            navLinks.forEach(link => {
                const linkHref = link.getAttribute('href');
                const linkPageName = linkHref.split('/').pop();

                if (linkPageName === currentPage || (currentPage === 'index.php' && linkHref === 'index.php')) {
                    link.classList.add('active');
                }
            });
        }
    } catch (e) {
        console.error("Error setting active navigation link:", e);
    }
}

function updateUIForLoggedInUser(username, loginSignupLink) {
    loginSignupLink.innerHTML = `User: ${username}`;
    loginSignupLink.href = 'profile.php';

    const dropdownMenu = document.getElementById('dropdownMenu');
    if (dropdownMenu) {
        const existingLogout = dropdownMenu.querySelector('.logout-link');
        if (existingLogout) {
            existingLogout.remove();
        }

        const logoutLink = document.createElement('a');
        logoutLink.href = '#';
        logoutLink.innerHTML = '➡️ Logout';
        logoutLink.classList.add('logout-link');
        logoutLink.onclick = function (event) {
            event.preventDefault();
            handleLogout();
        };

        dropdownMenu.appendChild(logoutLink);
    }
}

function updateUIForLoggedOutUser(loginSignupLink) {
    loginSignupLink.href = 'login.php';

    const dropdownMenu = document.getElementById('dropdownMenu');
    if (dropdownMenu) {
        const existingLogout = dropdownMenu.querySelector('.logout-link');
        if (existingLogout) {
            existingLogout.remove();
        }
    }
}

function handleLogout() {
    fetch('../handlers/logout.handler.php', {
        method: 'POST',
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Logout response:', data);
        
        // Clear localStorage if instructed
        if (data.clear_localStorage) {
            localStorage.removeItem('loggedInCodename');
        }
        
        if (data.success) {
            alert('Logged out successfully!');
            window.location.href = 'login.php';
        } else {
            alert('Logout failed: ' + data.message);
            // Still redirect to login on failure
            window.location.href = 'login.php';
        }
    })
    .catch(error => {
        console.error('Logout error:', error);
        // Clear localStorage on error
        localStorage.removeItem('loggedInCodename');
        alert('Logout error. Redirecting to login.');
        window.location.href = 'login.php';
    });
}

function toggleMenu() {
    var menu = document.getElementById("dropdownMenu");
    if (menu.style.display === "flex") {
        menu.style.display = "none";
    } else {
        menu.style.display = "flex";
    }
}

function openFeedback() {
    const feedbackOverlay = document.getElementById('feedbackOverlay');
    if (feedbackOverlay) {
        feedbackOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeFeedback() {
    const feedbackOverlay = document.getElementById('feedbackOverlay');
    if (feedbackOverlay) {
        feedbackOverlay.classList.remove('active');
        document.body.style.overflow = '';
        const radioButtons = document.querySelectorAll('input[name="satisfaction"]');
        radioButtons.forEach(radio => radio.checked = false);
        document.getElementById('suggestionTextbox').value = '';
    }
}

function submitFeedback() {
    const selectedSatisfaction = document.querySelector('input[name="satisfaction"]:checked');
    const suggestionText = document.getElementById('suggestionTextbox').value;

    let satisfactionValue = "Not selected";
    if (selectedSatisfaction) {
        satisfactionValue = selectedSatisfaction.value;
    }

    console.log("Feedback Submitted:");
    console.log("Satisfaction Level:", satisfactionValue);
    console.log("Suggestion/Concern:", suggestionText);

    alert('Thank you for your feedback! (This is a demo submission)');
    closeFeedback();
}

// Cart update functions with throttling
let cartUpdateInProgress = false;
let cartUpdateTimeout = null;

function updateCartIconCount() {
    // Prevent multiple simultaneous requests
    if (cartUpdateInProgress) {
        console.log('Cart update already in progress, skipping...');
        return;
    }

    // Throttle requests to prevent loops
    if (cartUpdateTimeout) {
        clearTimeout(cartUpdateTimeout);
    }

    cartUpdateTimeout = setTimeout(() => {
        performCartUpdate();
    }, 100); // Small delay to prevent rapid-fire requests
}

function performCartUpdate() {
    if (cartUpdateInProgress) return;

    cartUpdateInProgress = true;
    console.log('Performing cart update...');

    // Check if user is logged in first
    fetch('handlers/check-session.handler.php', {
        credentials: 'same-origin',
        signal: AbortSignal.timeout(5000) // 5 second timeout
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.logged_in) {
                // User is logged in - get count from server
                return fetch('handlers/cart.handler.php', {
                    credentials: 'same-origin',
                    signal: AbortSignal.timeout(5000) // 5 second timeout
                });
            } else {
                // User not logged in - use localStorage
                updateCartIconCountFromLocalStorage();
                return null;
            }
        })
        .then(response => {
            if (response) {
                return response.json();
            }
            return null;
        })
        .then(cartData => {
            if (cartData) {
                const cartCountElement = document.getElementById('cart-item-count');
                if (cartCountElement && cartData.success) {
                    cartCountElement.textContent = cartData.data.item_count || 0;
                }
            }
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
            updateCartIconCountFromLocalStorage();
        })
        .finally(() => {
            cartUpdateInProgress = false;
            console.log('Cart update completed');
        });
}

function updateCartIconCountFromLocalStorage() {
    const cart = JSON.parse(localStorage.getItem('cartItems')) || [];
    const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 0), 0);
    const cartCountElement = document.getElementById('cart-item-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}

function handleLogin() {
    const codename = document.getElementById('codename').value.trim();
    const password = document.getElementById('password').value;
    const formMessage = document.getElementById('form-message');
    formMessage.textContent = '';
    formMessage.className = 'info-message';

    // Example AJAX login (replace with your actual login logic)
    fetch('handlers/login.handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ codename, password }),
        credentials: 'same-origin'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Sync localStorage with successful login
                localStorage.setItem('loggedInCodename', data.user.username);
                window.location.href = 'index.php';
            } else {
                // Clear localStorage on failed login
                localStorage.removeItem('loggedInCodename');
                alert('Login failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Login error:', error);
            localStorage.removeItem('loggedInCodename');
            alert('Login error. Please try again.');
        });

    return false; // Prevent default form submit
}