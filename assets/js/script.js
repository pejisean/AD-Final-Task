// Preloader functionality
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('hidden');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

// All other DOM-related JavaScript should run after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {

    // --- Start of existing marketplace.js functionality (if applicable) ---
    // This block assumes the HTML elements for marketplace sorting exist on the current page.
    // If marketplace.js was only for specific pages, you might need to adjust this.
    const mainSortDropdown = document.querySelector('#sort-by-main');

    if (mainSortDropdown) {
        const newArrivalsGrid = document.querySelector('#new-arrivals-grid');
        const topSellersGrid = document.querySelector('#top-sellers-grid');

        if (newArrivalsGrid && topSellersGrid) {
            const allCards = [
                ...newArrivalsGrid.querySelectorAll('.product-card'),
                ...topSellersGrid.querySelectorAll('.product-card')
            ];

            const originalOrder = [...allCards];
            const newArrivalsCapacity = newArrivalsGrid.children.length;

            mainSortDropdown.addEventListener('change', function() {
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
    // --- End of existing marketplace.js functionality ---


    // --- Start of active navigation link highlighting ---
    try {
        const currentPage = window.location.pathname.split('/').pop();
        if (currentPage) {
            const navLinks = document.querySelectorAll('.main-nav a');
            navLinks.forEach(link => {
                // Adjust for pages being in 'pages/' directory
                const linkHref = link.getAttribute('href');
                const linkPageName = linkHref.split('/').pop();

                // Check if the current page matches the link's page name
                // Also handle the case where index.php is the current page and the link is "index.php"
                if (linkPageName === currentPage || (currentPage === 'index.php' && linkHref === 'index.php')) {
                    link.classList.add('active');
                }
            });
        }
    } catch (e) {
        console.error("Error setting active navigation link:", e);
    }
    // --- End of active navigation link highlighting ---


    // --- Start of Login/Signup dynamic link functionality ---
    const loggedInCodename = localStorage.getItem('loggedInCodename');
    const loginSignupLink = document.getElementById('login-signup-link');

    if (loginSignupLink) { // Ensure the element exists before trying to modify it
        if (loggedInCodename) {
            // If logged in, change text to codename and link to a profile/logout page
            loginSignupLink.innerHTML = `👤 ${loggedInCodename}`;
            // You might want to change this to a user profile page if you create one
            loginSignupLink.href = 'pages/profile.php'; // Placeholder for a user profile page

            // Add a logout link if the user is logged in
            const dropdownMenu = document.getElementById('dropdownMenu');
            const logoutLink = document.createElement('a');
            logoutLink.href = '#'; // This will be handled by JavaScript
            logoutLink.innerHTML = '➡️ Logout';
            logoutLink.classList.add('logout-link'); // Add a class for potential styling

            logoutLink.onclick = function(event) {
                event.preventDefault(); // Prevent default link behavior
                localStorage.removeItem('loggedInCodename'); // Clear logged-in state
                // Optionally remove 'registeredUsers' if you want a full reset on logout
                // localStorage.removeItem('registeredUsers'); // Uncomment if you want to clear all registered users on logout
                window.location.reload(); // Reload the page to reflect logout
            };

            // Insert logout link after the codename link
            // Check if dropdownMenu has children before inserting
            if (dropdownMenu.firstChild) {
                dropdownMenu.insertBefore(logoutLink, loginSignupLink.nextSibling);
            } else {
                dropdownMenu.appendChild(logoutLink); // Fallback if dropdown is empty
            }

        } else {
            // If not logged in, ensure it shows "Login / Sign Up" and links to login page
            loginSignupLink.innerHTML = '👤 Login / Sign Up';
            loginSignupLink.href = 'pages/login.php';
        }
    }
    // --- End of Login/Signup dynamic link functionality ---

}); // End of DOMContentLoaded

// --- Hamburger menu toggle function (kept global as it's called from HTML onclick) ---
function toggleMenu() {
    var menu = document.getElementById("dropdownMenu");
    if (menu.style.display === "flex") {
        menu.style.display = "none";
    } else {
        menu.style.display = "flex";
    }
}