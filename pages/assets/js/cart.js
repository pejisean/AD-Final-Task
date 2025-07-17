document.addEventListener("DOMContentLoaded", () => {
    const cartItemsList = document.getElementById('cart-items-list');
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const receiptOverlay = document.getElementById('receiptOverlay');
    const closeReceiptOverlayBtn = document.getElementById('closeReceiptOverlayBtn');
    const receiptCustomerName = document.getElementById('receiptCustomerName');
    const receiptItems = document.getElementById('receiptItems');
    const receiptTotalPrice = document.getElementById('receiptTotalPrice');
    const receiptIPAddress = document.getElementById('receiptIPAddress');
    const finalCheckoutBtn = document.getElementById('finalCheckoutBtn');

    // Ensure cart items have quantity
    function getCart() {
        let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        // Group items by name and price, sum quantity, and keep the image of the first occurrence
        const grouped = {};
        cart.forEach(item => {
            const key = item.name + '|' + item.price;
            if (!grouped[key]) {
                grouped[key] = { ...item };
            } else {
                grouped[key].quantity += item.quantity;
            }
        });
        return Object.values(grouped);
    }

    function renderCart() {
        const cart = getCart();
        cartItemsList.innerHTML = '';
        let subtotal = 0;

        if (cart.length === 0) {
            cartItemsList.innerHTML = '<p class="empty-cart-message">Your cart is empty.</p>';
        } else {
            cart.forEach(item => {
                const itemPriceValue = parseFloat(item.price.replace('₱', '').replace(',', ''));
                subtotal += itemPriceValue * item.quantity;
                cartItemsList.innerHTML += `
                    <div class="cart-item">
                        <img src="${item.image || 'assets/img/placeholder.jpg'}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3>${item.name}</h3>
                            <p>₱${itemPriceValue.toFixed(2)} x ${item.quantity}</p>
                        </div>
                    </div>
                `;
            });
        }
        cartSubtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
        cartTotalElement.textContent = `₱${subtotal.toFixed(2)}`;
    }

    function generateRandomIP() {
        return Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');
    }

    function openReceiptOverlay() {
        const cart = getCart();
        let subtotal = 0;
        receiptItems.innerHTML = '';
        cart.forEach(item => {
            const itemPriceValue = parseFloat(item.price.replace('₱', '').replace(',', ''));
            subtotal += itemPriceValue * item.quantity;
            receiptItems.innerHTML += `
                <p>
                    <strong>Item:</strong> ${item.name}<br>
                    <strong>Quantity:</strong> ${item.quantity}<br>
                    <strong>Price:</strong> ₱${itemPriceValue.toFixed(2)}
                </p>
            `;
        });
        receiptTotalPrice.textContent = subtotal.toFixed(2);
        receiptCustomerName.textContent = localStorage.getItem('loggedInCodename') || 'Guest';
        receiptIPAddress.textContent = generateRandomIP();
        receiptOverlay.style.display = 'flex';
    }

    function closeReceiptOverlay() {
        receiptOverlay.style.display = 'none';
    }

    renderCart();

    checkoutBtn.addEventListener('click', openReceiptOverlay);
    closeReceiptOverlayBtn.addEventListener('click', closeReceiptOverlay);

    finalCheckoutBtn.addEventListener('click', () => {
        alert('Checkout successful! Thank you for your purchase.');
        localStorage.removeItem('cartItems');
        closeReceiptOverlay();
        renderCart();
    });
});