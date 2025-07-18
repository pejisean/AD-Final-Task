document.addEventListener("DOMContentLoaded", () => {
    console.log('Cart script loaded');
    
    const cartItemsList = document.getElementById('cart-items-list');
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');
    const cartSummary = document.getElementById('cart-summary');
    const cartLoading = document.getElementById('cart-loading');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const receiptOverlay = document.getElementById('receiptOverlay');
    const closeReceiptOverlayBtn = document.getElementById('closeReceiptOverlayBtn');
    const receiptCustomerName = document.getElementById('receiptCustomerName');
    const receiptItems = document.getElementById('receiptItems');
    const receiptTotalPrice = document.getElementById('receiptTotalPrice');
    const receiptIPAddress = document.getElementById('receiptIPAddress');
    const finalCheckoutBtn = document.getElementById('finalCheckoutBtn');

    // Check if elements exist
    console.log('Cart elements found:', {
        cartItemsList: !!cartItemsList,
        cartLoading: !!cartLoading,
        emptyCartMessage: !!emptyCartMessage,
        checkoutBtn: !!checkoutBtn
    });

    let currentCartData = null;

    // Get configuration from the PHP-provided global
    const config = window.CART_CONFIG || {
        PLACEHOLDER_PATH: '../assets/img/electronics/powerbank.png',
        FALLBACK_IMAGES: [
            '../assets/img/electronics/powerbank.png',
            '../assets/img/tools/crowbar.png',
            '../assets/img/weapons/machete.png',
            '../assets/img/other/first.png',
            '../assets/img/electronics/led.png',
            '../assets/img/tools/hammer.png',
            '../assets/img/weapons/sentry.png',
            '../assets/img/other/survival.png',
            '../assets/img/electronics/circuit.png',
            '../assets/img/tools/axe.png'
        ],
        BASE_PATH: ''
    };

    console.log('Cart config:', config);

    // Get a random fallback image from available product assets
    function getRandomFallbackImage() {
        const fallbackImages = config.FALLBACK_IMAGES || [
            '../assets/img/electronics/powerbank.png'
        ];
        return fallbackImages[Math.floor(Math.random() * fallbackImages.length)];
    }

    // Improved image path resolution using actual product images
    function resolveImagePath(imagePath) {
        if (!imagePath) {
            return config.PLACEHOLDER_PATH || getRandomFallbackImage();
        }
        
        // If path starts with /, it's absolute from domain root
        if (imagePath.startsWith('/')) {
            return imagePath;
        }
        
        // If path starts with assets/, make it relative to pages context
        if (imagePath.startsWith('assets/')) {
            return '../' + imagePath;
        }
        
        // If path starts with ../, it's already relative to pages
        if (imagePath.startsWith('../')) {
            return imagePath;
        }
        
        // Default: assume it needs pages context prefix
        return '../' + imagePath;
    }

    // Create an image element with proper error handling
    function createImageWithFallback(src, alt, className) {
        const img = document.createElement('img');
        img.src = resolveImagePath(src);
        img.alt = alt;
        img.className = className;
        
        // Handle image load errors by trying fallback product images
        img.onerror = function() {
            const fallbackImage = getRandomFallbackImage();
            if (this.src !== fallbackImage) {
                this.src = fallbackImage;
            }
        };
        
        return img;
    }

    // Show/hide elements using CSS classes
    function showElement(element) {
        if (element) {
            element.classList.remove('hidden');
            element.style.display = 'block';
        }
    }

    function hideElement(element) {
        if (element) {
            element.classList.add('hidden');
            element.style.display = 'none';
        }
    }

    // Load cart from both server and localStorage
    function loadCart() {
        console.log('Loading cart from all sources...');
        
        showElement(cartLoading);
        hideElement(cartItemsList);
        hideElement(cartSummary);
        hideElement(emptyCartMessage);

        // First try to load from server
        fetch('../handlers/cart.handler.php', {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Cart response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Server cart data received:', data);
            hideElement(cartLoading);
            
            if (data.success && data.data && data.data.items && data.data.items.length > 0) {
                currentCartData = data.data;
                renderServerCart(data.data);
            } else {
                console.log('No server cart data, trying localStorage...');
                // Fallback to localStorage
                loadLocalStorageCart();
            }
        })
        .catch(error => {
            console.error('Error loading server cart:', error);
            hideElement(cartLoading);
            // Fallback to localStorage cart
            loadLocalStorageCart();
        });
    }

    // Render cart from server data
    function renderServerCart(cartData) {
        console.log('Rendering server cart:', cartData);
        
        const items = cartData.items || [];
        const total = cartData.total || 0;
        const itemCount = cartData.item_count || 0;

        if (items.length === 0) {
            showEmptyCart();
            return;
        }

        showElement(cartItemsList);
        showElement(cartSummary);
        hideElement(emptyCartMessage);
        
        if (cartItemsList) cartItemsList.innerHTML = '';

        items.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.dataset.itemId = item.item_id;

            const totalPrice = item.quantity * item.price_at_time;
            
            // Create image element with proper fallback
            const imageElement = createImageWithFallback(item.image_url, item.name, 'cart-item-image');

            itemElement.innerHTML = `
                <div class="cart-item-image-container"></div>
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p class="item-description">${item.description || ''}</p>
                    <p class="item-seller">Sold by: ${item.seller_name || 'Unknown'}</p>
                    <p class="item-price">₱${parseFloat(item.price_at_time).toFixed(2)} each</p>
                </div>
                <div class="cart-item-controls">
                    <div class="quantity-controls">
                        <button class="quantity-btn minus-btn" data-item-id="${item.item_id}">-</button>
                        <input type="number" value="${item.quantity}" min="1" max="${item.stock_quantity || 999}" 
                               class="quantity-input" data-item-id="${item.item_id}">
                        <button class="quantity-btn plus-btn" data-item-id="${item.item_id}">+</button>
                    </div>
                    <p class="item-total">₱${totalPrice.toFixed(2)}</p>
                    <button class="remove-item-btn" data-item-id="${item.item_id}">Remove</button>
                </div>
            `;
            
            // Add the image element to the container
            const imageContainer = itemElement.querySelector('.cart-item-image-container');
            if (imageContainer) {
                imageContainer.appendChild(imageElement);
            }
            
            if (cartItemsList) {
                cartItemsList.appendChild(itemElement);
            }
        });

        // Update totals
        if (cartSubtotalElement) cartSubtotalElement.textContent = `₱${total.toFixed(2)}`;
        if (cartTotalElement) cartTotalElement.textContent = `₱${total.toFixed(2)}`;

        // Add event listeners
        addCartEventListeners();
    }

    // Show empty cart
    function showEmptyCart() {
        console.log('Showing empty cart');
        hideElement(cartItemsList);
        hideElement(cartSummary);
        showElement(emptyCartMessage);
    }

    // Fallback to localStorage cart (enhanced version)
    function loadLocalStorageCart() {
        console.log('Loading localStorage cart...');
        
        const cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        console.log('LocalStorage cart found:', cart);
        
        if (cart.length === 0) {
            showEmptyCart();
            return;
        }

        showElement(cartItemsList);
        showElement(cartSummary);
        hideElement(emptyCartMessage);
        
        if (cartItemsList) cartItemsList.innerHTML = '';

        let subtotal = 0;
        cart.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.dataset.itemId = item.id || `local-${index}`;

            // Handle price parsing for localStorage items
            let itemPriceValue;
            if (typeof item.price === 'string') {
                itemPriceValue = parseFloat(item.price.replace('₱', '').replace(',', ''));
            } else {
                itemPriceValue = parseFloat(item.price);
            }
            
            const quantity = parseInt(item.quantity) || 1;
            const itemTotal = itemPriceValue * quantity;
            subtotal += itemTotal;

            // Create image element with proper fallback for localStorage items
            const imageElement = createImageWithFallback(item.image, item.name, 'cart-item-image');

            itemElement.innerHTML = `
                <div class="cart-item-image-container"></div>
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p class="item-description">${item.description || ''}</p>
                    <p class="item-price">₱${itemPriceValue.toFixed(2)} × ${quantity}</p>
                    <p class="item-source">Source: ${item.source || 'Local Storage'}</p>
                </div>
                <div class="cart-item-controls">
                    <div class="quantity-controls">
                        <button class="quantity-btn minus-btn-local" data-item-id="${item.id || `local-${index}`}">-</button>
                        <input type="number" value="${quantity}" min="1" max="999" 
                               class="quantity-input-local" data-item-id="${item.id || `local-${index}`}">
                        <button class="quantity-btn plus-btn-local" data-item-id="${item.id || `local-${index}`}">+</button>
                    </div>
                    <p class="item-total">₱${itemTotal.toFixed(2)}</p>
                    <button class="remove-item-btn-local" data-item-id="${item.id || `local-${index}`}">Remove</button>
                </div>
            `;
            
            // Add the image element to the container
            const imageContainer = itemElement.querySelector('.cart-item-image-container');
            if (imageContainer) {
                imageContainer.appendChild(imageElement);
            }
            
            if (cartItemsList) {
                cartItemsList.appendChild(itemElement);
            }
        });

        // Update totals
        if (cartSubtotalElement) cartSubtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
        if (cartTotalElement) cartTotalElement.textContent = `₱${subtotal.toFixed(2)}`;

        // Add event listeners for localStorage items
        addLocalStorageEventListeners();
        
        // Set current cart data for localStorage
        currentCartData = {
            items: cart,
            total: subtotal,
            item_count: cart.length,
            source: 'localStorage'
        };
    }

    // Add event listeners for localStorage cart items
    function addLocalStorageEventListeners() {
        // Quantity controls for localStorage items
        document.querySelectorAll('.minus-btn-local').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                updateLocalStorageQuantity(itemId, -1);
            });
        });

        document.querySelectorAll('.plus-btn-local').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                updateLocalStorageQuantity(itemId, 1);
            });
        });

        document.querySelectorAll('.quantity-input-local').forEach(input => {
            input.addEventListener('change', (e) => {
                const itemId = e.target.dataset.itemId;
                const newQuantity = parseInt(e.target.value);
                if (newQuantity > 0) {
                    setLocalStorageQuantity(itemId, newQuantity);
                } else {
                    removeFromLocalStorage(itemId);
                }
            });
        });

        // Remove buttons for localStorage items
        document.querySelectorAll('.remove-item-btn-local').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                removeFromLocalStorage(itemId);
            });
        });
    }

    // Update localStorage item quantity
    function updateLocalStorageQuantity(itemId, change) {
        let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        const itemIndex = cart.findIndex(item => (item.id || `local-${cart.indexOf(item)}`) === itemId);
        
        if (itemIndex > -1) {
            cart[itemIndex].quantity = Math.max(1, (cart[itemIndex].quantity || 1) + change);
            localStorage.setItem('cartItems', JSON.stringify(cart));
            loadLocalStorageCart(); // Refresh display
        }
    }

    // Set localStorage item quantity
    function setLocalStorageQuantity(itemId, quantity) {
        let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        const itemIndex = cart.findIndex(item => (item.id || `local-${cart.indexOf(item)}`) === itemId);
        
        if (itemIndex > -1) {
            cart[itemIndex].quantity = quantity;
            localStorage.setItem('cartItems', JSON.stringify(cart));
            loadLocalStorageCart(); // Refresh display
        }
    }

    // Remove item from localStorage
    function removeFromLocalStorage(itemId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }
        
        let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        cart = cart.filter(item => (item.id || `local-${cart.indexOf(item)}`) !== itemId);
        localStorage.setItem('cartItems', JSON.stringify(cart));
        loadLocalStorageCart(); // Refresh display
        
        // Update cart icon count
        if (typeof window.updateCartIconCount === 'function') {
            window.updateCartIconCount();
        }
    }

    // Add event listeners to cart controls (for server cart)
    function addCartEventListeners() {
        // Quantity controls
        document.querySelectorAll('.minus-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                const quantityInput = document.querySelector(`input[data-item-id="${itemId}"]`);
                const currentQuantity = parseInt(quantityInput.value);
                
                if (currentQuantity > 1) {
                    updateCartItemQuantity(itemId, currentQuantity - 1);
                } else {
                    removeFromCart(itemId);
                }
            });
        });

        document.querySelectorAll('.plus-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                const quantityInput = document.querySelector(`input[data-item-id="${itemId}"]`);
                const currentQuantity = parseInt(quantityInput.value);
                const maxQuantity = parseInt(quantityInput.max);
                
                if (currentQuantity < maxQuantity) {
                    updateCartItemQuantity(itemId, currentQuantity + 1);
                } else {
                    alert('Cannot add more items. Stock limit reached.');
                }
            });
        });

        // Remove buttons
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                removeFromCart(itemId);
            });
        });
    }

    // Update cart item quantity (for server cart)
    function updateCartItemQuantity(itemId, quantity) {
        fetch('../handlers/cart.handler.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                item_id: parseInt(itemId),
                quantity: quantity
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart(); // Refresh cart
            } else {
                console.error('Failed to update cart:', data.message);
                alert('Failed to update cart. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            alert('Error updating cart. Please try again.');
        });
    }

    // Remove item from cart (for server cart)
    function removeFromCart(itemId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        fetch('../handlers/cart.handler.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                item_id: parseInt(itemId)
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart(); // Refresh cart
            } else {
                console.error('Failed to remove item:', data.message);
                alert('Failed to remove item. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error removing item:', error);
            alert('Error removing item. Please try again.');
        });
    }

    // Generate random IP
    function generateRandomIP() {
        return Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');
    }

    // Open receipt overlay
    function openReceiptOverlay() {
        if (!currentCartData || !currentCartData.items || currentCartData.items.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        if (receiptItems) receiptItems.innerHTML = '';
        
        currentCartData.items.forEach(item => {
            const itemDiv = document.createElement('div');
            
            // Handle both server and localStorage item formats with better error handling
            const itemName = item.name || 'Unknown Item';
            const itemQuantity = parseInt(item.quantity) || 1;
            
            // Better price handling with multiple fallbacks
            let itemPrice = 0;
            if (item.price_at_time !== undefined && item.price_at_time !== null) {
                itemPrice = parseFloat(item.price_at_time);
            } else if (item.price !== undefined && item.price !== null) {
                if (typeof item.price === 'string') {
                    itemPrice = parseFloat(item.price.replace('₱', '').replace(',', ''));
                } else {
                    itemPrice = parseFloat(item.price);
                }
            }
            
            // Ensure itemPrice is a valid number
            if (isNaN(itemPrice) || itemPrice < 0) {
                itemPrice = 0;
            }
            
            const itemTotal = itemQuantity * itemPrice;
            
            itemDiv.innerHTML = `
                <p><strong>${itemName}</strong></p>
                <p>Quantity: ${itemQuantity}</p>
                <p>Price: ₱${itemPrice.toFixed(2)} each</p>
                <p>Total: ₱${itemTotal.toFixed(2)}</p>
                <hr>
            `;
            
            if (receiptItems) receiptItems.appendChild(itemDiv);
        });

        // Calculate total with proper error handling
        let totalPrice = 0;
        if (currentCartData.total !== undefined && currentCartData.total !== null) {
            totalPrice = parseFloat(currentCartData.total);
        } else {
            // Calculate total from items if cart total is not available
            totalPrice = currentCartData.items.reduce((sum, item) => {
                const quantity = parseInt(item.quantity) || 1;
                let price = 0;
                
                if (item.price_at_time !== undefined && item.price_at_time !== null) {
                    price = parseFloat(item.price_at_time);
                } else if (item.price !== undefined && item.price !== null) {
                    if (typeof item.price === 'string') {
                        price = parseFloat(item.price.replace('₱', '').replace(',', ''));
                    } else {
                        price = parseFloat(item.price);
                    }
                }
                
                if (isNaN(price) || price < 0) {
                    price = 0;
                }
                
                return sum + (quantity * price);
            }, 0);
        }
        
        // Ensure total is a valid number
        if (isNaN(totalPrice) || totalPrice < 0) {
            totalPrice = 0;
        }

        if (receiptTotalPrice) receiptTotalPrice.textContent = totalPrice.toFixed(2);
        
        // Get customer name from session or default
        fetch('../handlers/check-session.handler.php', {
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.logged_in) {
                if (receiptCustomerName) receiptCustomerName.textContent = data.user.username;
            } else {
                if (receiptCustomerName) receiptCustomerName.textContent = 'Guest User';
            }
        })
        .catch(() => {
            if (receiptCustomerName) receiptCustomerName.textContent = 'Guest User';
        });

        if (receiptIPAddress) receiptIPAddress.textContent = generateRandomIP();
        if (receiptOverlay) receiptOverlay.style.display = 'flex';
    }

    // Close receipt overlay
    function closeReceiptOverlay() {
        if (receiptOverlay) receiptOverlay.style.display = 'none';
    }

    // Complete checkout
    function completeCheckout() {
        if (!currentCartData || !currentCartData.items || currentCartData.items.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Handle different checkout methods based on cart source
        if (currentCartData.source === 'localStorage') {
            // For localStorage carts, just clear the cart and show success
            localStorage.removeItem('cartItems');
            alert('Order completed successfully!');
            closeReceiptOverlay();
            loadCart(); // Refresh to show empty cart
            
            // Update cart icon count
            if (typeof window.updateCartIconCount === 'function') {
                window.updateCartIconCount();
            }
        } else {
            // For server carts, use the receipt handler
            const checkoutData = {
                items: currentCartData.items,
                total_amount: currentCartData.total,
                shipping_address: receiptIPAddress ? receiptIPAddress.textContent : 'Unknown',
                payment_method: 'cash'
            };

            fetch('../handlers/receipt.handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(checkoutData),
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order completed successfully!');
                    closeReceiptOverlay();
                    loadCart(); // Refresh to show empty cart
                } else {
                    alert('Checkout failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Checkout error:', error);
                alert('Checkout failed. Please try again.');
            });
        }
    }

    // Event listeners
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', openReceiptOverlay);
    }

    if (closeReceiptOverlayBtn) {
        closeReceiptOverlayBtn.addEventListener('click', closeReceiptOverlay);
    }

    if (finalCheckoutBtn) {
        finalCheckoutBtn.addEventListener('click', completeCheckout);
    }

    // Initialize cart
    console.log('Initializing cart...');
    loadCart();
});