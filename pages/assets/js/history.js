window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('hidden');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

function addPurchaseToHistory(item) {
    let history = JSON.parse(localStorage.getItem('purchaseHistory')) || [];
    history.push(item);
    localStorage.setItem('purchaseHistory', JSON.stringify(history));
    console.log('Item added to history:', item);
}

function renderPurchaseHistory() {
    const marketplaceGrid = document.getElementById('marketplace-purchases');
    const shopGrid = document.getElementById('shop-purchases');
    const noMarketplaceHistory = document.getElementById('no-marketplace-history');
    const noShopHistory = document.getElementById('no-shop-history');

    if (!marketplaceGrid || !shopGrid) return;

    let history = JSON.parse(localStorage.getItem('purchaseHistory')) || [];

    marketplaceGrid.innerHTML = '';
    shopGrid.innerHTML = '';

    let hasMarketplaceHistory = false;
    let hasShopHistory = false;

    history.forEach(item => {
        const purchaseCard = document.createElement('div');
        purchaseCard.classList.add('purchase-card');

        const itemImage = item.image.startsWith('../') ? item.image : `../${item.image}`;

        purchaseCard.innerHTML = `
            <img src="${itemImage}" alt="${item.name}">
            <div class="purchase-details">
                <h3>Item: ${item.name}</h3>
                <p>Bought from: ${item.seller}</p>
                <p>Date: ${item.date}</p>
                <p class="purchase-price">Price: ${item.price}</p>
            </div>
        `;

        if (item.source === 'Marketplace') {
            marketplaceGrid.appendChild(purchaseCard);
            hasMarketplaceHistory = true;
        } else if (item.source === 'Shop') {
            shopGrid.appendChild(purchaseCard);
            hasShopHistory = true;
        }
    });

    if (hasMarketplaceHistory) {
        if (noMarketplaceHistory) noMarketplaceHistory.style.display = 'none';
    } else {
        if (noMarketplaceHistory) noMarketplaceHistory.style.display = 'block';
    }

    if (hasShopHistory) {
        if (noShopHistory) noShopHistory.style.display = 'none';
    } else {
        if (noShopHistory) noShopHistory.style.display = 'block';
    }
}


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

    const shopProductCards = document.querySelectorAll('.product-grid .product-card');
    shopProductCards.forEach(card => {
        const buyButton = card.querySelector('.buy-btn');
        const addToCartButton = card.querySelector('.add-cart-btn');
        const itemName = card.querySelector('h3')?.textContent;
        const itemPrice = card.querySelector('p:not(.product-description)')?.textContent;
        const itemImage = card.querySelector('img')?.getAttribute('src');

        const purchaseData = {
            name: itemName,
            image: itemImage,
            source: 'Shop',
            seller: 'The Last Trade Post',
            date: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }),
            price: itemPrice
        };

        if (buyButton) {
            buyButton.addEventListener('click', function(event) {
                event.preventDefault();
                addPurchaseToHistory(purchaseData);
                alert(`${itemName} purchased from The Last Trade Post!`);
            });
        }
        if (addToCartButton) {
            addToCartButton.addEventListener('click', function(event) {
                event.preventDefault();
                addPurchaseToHistory(purchaseData);
                alert(`${itemName} added to cart from The Last Trade Post!`);
            });
        }
    });

    const marketplaceCards = document.querySelectorAll('.marketplace-main .product-card');
    marketplaceCards.forEach(card => {
        const viewDetailsButton = card.querySelector('button');
        const itemName = card.querySelector('h3')?.textContent;
        const itemPrice = card.querySelector('p:not(.product-description)')?.textContent;
        const itemImage = card.querySelector('img')?.getAttribute('src');
        const sellerName = "User Listed";

        const purchaseData = {
            name: itemName,
            image: itemImage,
            source: 'Marketplace',
            seller: sellerName,
            date: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }),
            price: itemPrice
        };

        if (viewDetailsButton) {
            viewDetailsButton.addEventListener('click', function() {
                addPurchaseToHistory(purchaseData);
                alert(`${itemName} purchased from the Marketplace!`);
            });
        }
    });

    if (window.location.pathname.includes('history.php')) {
        renderPurchaseHistory();
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

    alert('Thank you for your feedback! The overlay will close shortly.');

    setTimeout(() => {
        closeFeedback();
    }, 3000);
}
