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

    const loggedInCodename = localStorage.getItem('loggedInCodename');
    const loginSignupLink = document.getElementById('login-signup-link');

    if (loginSignupLink) {
        if (loggedInCodename) {
            loginSignupLink.innerHTML = `👤 ${loggedInCodename}`;
            loginSignupLink.href = 'pages/profile.php';

            const dropdownMenu = document.getElementById('dropdownMenu');
            const logoutLink = document.createElement('a');
            logoutLink.href = '#';
            logoutLink.innerHTML = '➡️ Logout';
            logoutLink.classList.add('logout-link');

            logoutLink.onclick = function(event) {
                event.preventDefault();
                localStorage.removeItem('loggedInCodename');
                window.location.reload();
            };

            if (dropdownMenu.firstChild) {
                dropdownMenu.insertBefore(logoutLink, loginSignupLink.nextSibling);
            } else {
                dropdownMenu.appendChild(logoutLink);
            }

        } else {
            loginSignupLink.innerHTML = '👤 Login / Sign Up';
            loginSignupLink.href = 'pages/login.php';
        }
    }

});

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

    alert('Thank you for your feedback! The overlay will close shortly.'); // Changed alert message

    // Close the feedback overlay after 3 seconds (3000 milliseconds)
    setTimeout(() => {
        closeFeedback();
    }, 3000);
}