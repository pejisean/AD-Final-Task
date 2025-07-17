document.addEventListener("DOMContentLoaded", () => {
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

    // Load cart from server
    function loadCartFromServer() {
        cartLoading.style.display = 'block';
        cartItemsList.style.display = 'none';
        cartSummary.style.display = 'none';
        emptyCartMessage.style.display = 'none';

        fetch('../handlers/cart.handler.php', {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            cartLoading.style.display = 'none';
            
            if (data.success) {
                currentCartData = data.data;
                renderServerCart(data.data);
            } else {
                console.error('Failed to load cart:', data.message);
                showEmptyCart();
            }
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            cartLoading.style.display = 'none';
            // Fallback to localStorage cart
            loadLocalStorageCart();
        });
    }

    // Render cart from server data
    function renderServerCart(cartData) {
        const items = cartData.items || [];
        const total = cartData.total || 0;
        const itemCount = cartData.item_count || 0;

        if (items.length === 0) {
            showEmptyCart();
            return;
        }

        cartItemsList.style.display = 'block';
        cartSummary.style.display = 'block';
        cartItemsList.innerHTML = '';

        items.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.dataset.itemId = item.item_id;

            const totalPrice = item.quantity * item.price_at_time;
            
            // Use the same image path resolution logic as marketplace
            const imageUrl = resolveImagePath(item.image_url);

            itemElement.innerHTML = `
                <img src="${imageUrl}" alt="${item.name}" class="cart-item-image" 
                     onerror="this.src='../assets/img/placeholder.jpg'">
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
            cartItemsList.appendChild(itemElement);
        });

        // Update totals
        cartSubtotalElement.textContent = `₱${total.toFixed(2)}`;
        cartTotalElement.textContent = `₱${total.toFixed(2)}`;

        // Add event listeners
        addCartEventListeners();
    }

    // Add this function to handle image path resolution (same logic as marketplace)
    function resolveImagePath(imagePath) {
        if (!imagePath) {
            return '../assets/img/placeholder.jpg';
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

    // Add event listeners to cart controls
    function addCartEventListeners() {
        // Quantity controls
        document.querySelectorAll('.minus-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                const newQuantity = Math.max(1, parseInt(input.value) - 1);
                updateCartItemQuantity(itemId, newQuantity);
            });
        });

        document.querySelectorAll('.plus-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const itemId = e.target.dataset.itemId;
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                const newQuantity = parseInt(input.value) + 1;
                updateCartItemQuantity(itemId, newQuantity);
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', (e) => {
                const itemId = e.target.dataset.itemId;
                const newQuantity = Math.max(1, parseInt(e.target.value));
                updateCartItemQuantity(itemId, newQuantity);
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
                loadCartFromServer(); // Reload cart
                updateCartIconCount(); // Update header cart count
            } else {
                alert('Failed to update cart: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            alert('Error updating cart. Please try again.');
        });
    }

    // Remove item from cart
    function removeFromCart(itemId) {
        console.log('Attempting to remove item:', itemId); // Debug log
        
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
            console.log('Remove response:', data); // Debug log
            if (data.success) {
                loadCartFromServer(); // Reload cart
                updateCartIconCount(); // Update header cart count
                alert('Item removed from cart');
            } else {
                alert('Failed to remove item: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error removing from cart:', error);
            alert('Error removing item. Please try again.');
        });
    }

    // Show empty cart
    function showEmptyCart() {
        cartItemsList.style.display = 'none';
        cartSummary.style.display = 'none';
        emptyCartMessage.style.display = 'block';
    }

    // Fallback to localStorage cart
    function loadLocalStorageCart() {
        const cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        if (cart.length === 0) {
            showEmptyCart();
            return;
        }

        cartItemsList.style.display = 'block';
        cartSummary.style.display = 'block';
        cartItemsList.innerHTML = '';

        let subtotal = 0;
        cart.forEach(item => {
            const itemPriceValue = parseFloat(item.price.replace('₱', '').replace(',', ''));
            subtotal += itemPriceValue * item.quantity;

            // Use the same image path resolution for localStorage items
            const imageUrl = resolveImagePath(item.image);

            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <img src="${imageUrl}" alt="${item.name}" class="cart-item-image" 
                     onerror="this.src='../assets/img/placeholder.jpg'">
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p>₱${itemPriceValue.toFixed(2)} x ${item.quantity}</p>
                </div>
                <div class="cart-item-controls">
                    <span>Local Storage Cart</span>
                </div>
            `;
            cartItemsList.appendChild(itemElement);
        });

        cartSubtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
        cartTotalElement.textContent = `₱${subtotal.toFixed(2)}`;
    }

    // Generate random IP
    function generateRandomIP() {
        return Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');
    }

    // Open receipt overlay
    function openReceiptOverlay() {
        if (!currentCartData || !currentCartData.items.length) {
            alert('Your cart is empty!');
            return;
        }

        receiptItems.innerHTML = '';
        currentCartData.items.forEach(item => {
            const totalPrice = item.quantity * item.price_at_time;
            receiptItems.innerHTML += `
                <p>
                    <strong>Item:</strong> ${item.name}<br>
                    <strong>Quantity:</strong> ${item.quantity}<br>
                    <strong>Price:</strong> ₱${totalPrice.toFixed(2)}
                </p>
            `;
        });

        receiptTotalPrice.textContent = currentCartData.total.toFixed(2);
        
        // Get customer name from session or default
        fetch('../handlers/check-session.handler.php', {
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.logged_in) {
                receiptCustomerName.textContent = data.user.username || 'Member';
            } else {
                receiptCustomerName.textContent = 'Guest';
            }
        })
        .catch(() => {
            receiptCustomerName.textContent = 'Guest';
        });

        receiptIPAddress.textContent = generateRandomIP();
        receiptOverlay.style.display = 'flex';
    }

    // Close receipt overlay
    function closeReceiptOverlay() {
        receiptOverlay.style.display = 'none';
    }

    // Complete checkout
    function completeCheckout() {
        if (!currentCartData || !currentCartData.items.length) {
            alert('Your cart is empty!');
            return;
        }

        // Create receipt data in the format expected by the handler
        const receiptData = {
            total_amount: currentCartData.total,
            tax_amount: currentCartData.total * 0.10, // 10% tax
            shipping_address: receiptIPAddress.textContent,
            billing_address: receiptIPAddress.textContent,
            payment_method: 'cash',
            payment_status: 'completed',
            order_status: 'processing',
            notes: 'Cart checkout order',
            items: currentCartData.items.map(item => ({
                item_id: item.item_id,
                item_name: item.name,
                item_description: item.description || '',
                quantity: item.quantity,
                unit_price: item.price_at_time,
                total_price: item.quantity * item.price_at_time,
                seller_name: item.seller_name || 'Unknown'
            }))
        };

        console.log('Sending receipt data:', receiptData); // Debug log

        fetch('../handlers/receipt.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(receiptData),
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Receipt response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Receipt response:', data); // Debug log
            if (data.success) {
                // Show success message with receipt details
                alert(`Order completed successfully!\nReceipt #${data.data.receipt_number || 'Generated'}\nTotal: ₱${currentCartData.total.toFixed(2)}`);
                
                // Close overlay and reload cart
                closeReceiptOverlay();
                loadCartFromServer(); // Reload cart (should be empty now)
                updateCartIconCount(); // Update header cart count
                
                // Optionally redirect to a receipt page or show detailed receipt
                if (data.data.receipt_id) {
                    // You can redirect to a receipt detail page if you have one
                    // window.location.href = `receipt.php?id=${data.data.receipt_id}`;
                }
            } else {
                console.error('Receipt creation failed:', data.message);
                alert('Failed to complete order: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error completing checkout:', error);
            alert('Error completing order. Please try again.');
        });
    }

    // Update cart icon count in header
    function updateCartIconCount() {
        if (typeof window.updateCartIconCount === 'function') {
            window.updateCartIconCount();
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
    loadCartFromServer();
});