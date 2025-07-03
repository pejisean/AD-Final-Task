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

// Cart functions
function saveCart(cart) {
    localStorage.setItem('cartItems', JSON.stringify(cart));
    updateCartIconCount();
}

function getCart() {
    return JSON.parse(localStorage.getItem('cartItems')) || [];
}

function updateCartIconCount() {
    const cart = getCart();
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartCountElement = document.getElementById('cart-item-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}

function renderCart() {
    const cartItemsList = document.getElementById('cart-items-list');
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');
    const emptyCartMessage = document.querySelector('.empty-cart-message');

    if (!cartItemsList || !cartSubtotalElement || !cartTotalElement) return;

    const cart = getCart();
    cartItemsList.innerHTML = ''; // Clear existing items

    let subtotal = 0;

    if (cart.length === 0) {
        if (emptyCartMessage) emptyCartMessage.style.display = 'block';
    } else {
        if (emptyCartMessage) emptyCartMessage.style.display = 'none';
        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            const itemPriceValue = parseFloat(item.price.replace('₱', '').replace(',', ''));
            subtotal += itemPriceValue * item.quantity;

            itemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p>${item.price} x ${item.quantity}</p>
                </div>
                <div class="cart-item-controls">
                    <input type="number" value="${item.quantity}" min="1" data-item-id="${item.id}">
                    <button class="remove-item-btn" data-item-id="${item.id}">×</button>
                </div>
            `;
            cartItemsList.appendChild(itemElement);
        });
    }

    cartSubtotalElement.textContent = `₱${subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    cartTotalElement.textContent = `₱${subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    // Add event listeners for quantity changes and remove buttons
    cartItemsList.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const newQuantity = parseInt(this.value);
            updateCartItemQuantity(itemId, newQuantity);
        });
    });

    cartItemsList.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeFromCart(itemId);
        });
    });
}

function addToCart(item) {
    let cart = getCart();
    const existingItemIndex = cart.findIndex(cartItem => cartItem.id === item.id);

    if (existingItemIndex > -1) {
        cart[existingItemIndex].quantity += 1;
    } else {
        item.quantity = 1;
        cart.push(item);
    }
    saveCart(cart);
    renderCart();
    alert(`${item.name} added to cart!`);
}

function removeFromCart(itemId) {
    let cart = getCart();
    cart = cart.filter(item => item.id !== itemId);
    saveCart(cart);
    renderCart();
}

function updateCartItemQuantity(itemId, quantity) {
    let cart = getCart();
    const itemIndex = cart.findIndex(item => item.id === itemId);
    if (itemIndex > -1) {
        if (quantity <= 0) {
            cart.splice(itemIndex, 1); // Remove if quantity is 0 or less
        } else {
            cart[itemIndex].quantity = quantity;
        }
    }
    saveCart(cart);
    renderCart();
}

function openCart() {
    const cartOverlay = document.getElementById('cartOverlay');
    if (cartOverlay) {
        cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        renderCart(); // Render cart items when opening
    }
}

function closeCart() {
    const cartOverlay = document.getElementById('cartOverlay');
    if (cartOverlay) {
        cartOverlay.classList.remove('active');
        document.body.style.overflow = '';
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
    shopProductCards.forEach((card, index) => { // Added index for unique ID
        const buyButton = card.querySelector('.buy-btn');
        const addToCartButton = card.querySelector('.add-cart-btn');
        const itemName = card.querySelector('h3')?.textContent;
        const itemPrice = card.querySelector('p:not(.product-description)')?.textContent;
        const itemImage = card.querySelector('img')?.getAttribute('src');
        const itemId = `shop-item-${index}`; // Unique ID for cart item

        const purchaseData = {
            id: itemId, // Add ID for cart
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
                addToCart(purchaseData); // Use addToCart for "Add to Cart"
            });
        }
    });

    const marketplaceCards = document.querySelectorAll('.marketplace-main .product-card');
    marketplaceCards.forEach((card, index) => { // Added index for unique ID
        const viewDetailsButton = card.querySelector('button');
        const itemName = card.querySelector('h3')?.textContent;
        const itemPrice = card.querySelector('p:not(.product-description)')?.textContent;
        const itemImage = card.querySelector('img')?.getAttribute('src');
        const sellerName = "User Listed";
        const itemId = `marketplace-item-${index}`; // Unique ID for cart item

        const purchaseData = {
            id: itemId, // Add ID for cart
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

    updateCartIconCount(); // Initial update of cart count on page load

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
