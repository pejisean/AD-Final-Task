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

    let currentCartData = null;

    // Show/hide elements
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

    // Load cart from server and localStorage
    function loadCart() {
        console.log('Loading cart...');

        showElement(cartLoading);
        hideElement(cartItemsList);
        hideElement(cartSummary);
        hideElement(emptyCartMessage);

        // Try to load from server first
        fetch('../handlers/cart.handler.php', {
            method: 'GET',
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                console.log('Server cart data:', data);
                hideElement(cartLoading);

                if (data.success && data.data && data.data.items && data.data.items.length > 0) {
                    currentCartData = data.data;
                    renderServerCart(data.data);
                } else {
                    loadLocalStorageCart();
                }
            })
            .catch(error => {
                console.error('Error loading server cart:', error);
                hideElement(cartLoading);
                loadLocalStorageCart();
            });
    }

    // Render cart from server data (NO IMAGES)
    function renderServerCart(cartData) {
        console.log('Rendering server cart:', cartData);

        const items = cartData.items || [];
        const total = cartData.total || 0;

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

            itemElement.innerHTML = `
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p class="item-description">${item.description || ''}</p>
                    <p class="item-seller">Customer: ${item.seller_name || 'Unknown'}</p>
                    <p class="item-price">₱${parseFloat(item.price_at_time).toFixed(2)} × ${item.quantity}</p>
                    <p class="item-source"> Source:${item.source || 'Marketplace'}</p>
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

    // Load localStorage cart (NO IMAGES)
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

            // Handle price parsing
            let itemPriceValue;
            if (typeof item.price === 'string') {
                itemPriceValue = parseFloat(item.price.replace('₱', '').replace(',', ''));
            } else {
                itemPriceValue = parseFloat(item.price);
            }

            if (isNaN(itemPriceValue)) {
                itemPriceValue = 0;
            }

            const quantity = parseInt(item.quantity) || 1;
            const itemTotal = itemPriceValue * quantity;
            subtotal += itemTotal;

            itemElement.innerHTML = `
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p class="item-description">${item.description || ''}</p>
                    <p class="item-price">₱${itemPriceValue.toFixed(2)} × ${quantity}</p>
                    <p class="item-source">Source: ${item.source || 'Shop'}</p>
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

            if (cartItemsList) {
                cartItemsList.appendChild(itemElement);
            }
        });

        // Update totals
        if (cartSubtotalElement) cartSubtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
        if (cartTotalElement) cartTotalElement.textContent = `₱${subtotal.toFixed(2)}`;

        // Add event listeners
        addLocalStorageEventListeners();

        // Set current cart data
        currentCartData = {
            items: cart,
            total: subtotal,
            item_count: cart.length,
            source: 'localStorage'
        };
    }

    // Add event listeners for localStorage cart items
    function addLocalStorageEventListeners() {
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
            loadLocalStorageCart();
        }
    }

    // Set localStorage item quantity
    function setLocalStorageQuantity(itemId, quantity) {
        let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        const itemIndex = cart.findIndex(item => (item.id || `local-${cart.indexOf(item)}`) === itemId);

        if (itemIndex > -1) {
            cart[itemIndex].quantity = quantity;
            localStorage.setItem('cartItems', JSON.stringify(cart));
            loadLocalStorageCart();
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
        loadLocalStorageCart();

        if (typeof window.updateCartIconCount === 'function') {
            window.updateCartIconCount();
        }
    }

    // Add event listeners for server cart
    function addCartEventListeners() {
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

        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                removeFromCart(itemId);
            });
        });
    }

    // Update cart item quantity
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
                    loadCart();
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

    // Remove item from cart
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
                    loadCart();
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

            const itemName = item.name || 'Unknown Item';
            const itemQuantity = parseInt(item.quantity) || 1;

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

        // Calculate total
        let totalPrice = 0;
        if (currentCartData.total !== undefined && currentCartData.total !== null) {
            totalPrice = parseFloat(currentCartData.total);
        } else {
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

        if (isNaN(totalPrice) || totalPrice < 0) {
            totalPrice = 0;
        }

        if (receiptTotalPrice) receiptTotalPrice.textContent = totalPrice.toFixed(2);

        // Get customer name
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

        if (currentCartData.source === 'localStorage') {
            localStorage.removeItem('cartItems');
            alert('Order completed successfully!');
            closeReceiptOverlay();
            loadCart();

            if (typeof window.updateCartIconCount === 'function') {
                window.updateCartIconCount();
            }
        } else {
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
                        loadCart();
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

    // After cart is loaded, check for ?checkout=1 in URL
    function openReceiptIfCheckoutParam() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('checkout') === '1') {
            // Wait for cart to load, then open receipt overlay
            setTimeout(() => {
                if (typeof openReceiptOverlay === 'function') {
                    openReceiptOverlay();
                }
            }, 500); // Adjust delay if needed
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

    // Call after cart is loaded
    loadCart();
    openReceiptIfCheckoutParam();
});