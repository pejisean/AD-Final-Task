document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".add-cart-btn");
    const overlay = document.getElementById("addToCartOverlay");
    const itemNameEl = document.getElementById("cartItemName");
    const itemPriceEl = document.getElementById("cartItemPrice");
    const totalPriceEl = document.getElementById("cartTotalPrice");
    const ipAddressEl = document.getElementById("cartIPAddress");
    const closeButton = document.getElementById("closeAddToCartOverlayBtn");
    const proceedAddButton = document.getElementById("proceedAddButton");

    if (!overlay) {
        console.error("Add to Cart overlay element not found");
        return;
    }

    if (closeButton) {
        closeButton.addEventListener("click", closeOverlay);
    }

    function generateRandomIP() {
        return `192.168.${Math.floor(Math.random() * 255)}.${Math.floor(Math.random() * 255)}`;
    }

    let currentItem = {};

    addToCartButtons.forEach(button => {
        button.addEventListener("click", event => {
            event.preventDefault();

            const itemName = button.getAttribute("data-item-name");
            const itemPrice = button.getAttribute("data-item-price");
            const ip = generateRandomIP();

            itemNameEl.textContent = itemName;
            itemPriceEl.textContent = parseFloat(itemPrice).toFixed(2);
            totalPriceEl.textContent = parseFloat(itemPrice).toFixed(2);
            ipAddressEl.textContent = ip;

            currentItem = {
                name: itemName,
                price: parseFloat(itemPrice).toFixed(2),
                ip: ip,
                item_id: generateItemId(itemName),
                quantity: 1
            };

            overlay.style.display = "flex";
        });
    });

    if (proceedAddButton) {
        proceedAddButton.addEventListener("click", () => {
            fetch('../handlers/check-session.handler.php', {
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.logged_in) {
                    addToServerCart(currentItem);
                } else {
                    addToLocalStorageCart(currentItem);
                }
            })
            .catch(error => {
                console.error('Session check failed:', error);
                addToLocalStorageCart(currentItem);
            });
        });
    }

    function addToServerCart(item) {
        fetch('../handlers/cart.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                item_name: item.name,
                item_price: item.price,
                quantity: item.quantity
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Item added to cart!");
                updateCartIconCount();
            } else {
                alert("Failed to add item to cart: " + (data.message || 'Unknown error'));
            }
            closeOverlay();
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            alert("Error adding item to cart. Please try again.");
            closeOverlay();
        });
    }

    function addToLocalStorageCart(item) {
        let cart = JSON.parse(localStorage.getItem('cartItems')) || [];

        const existingItemIndex = cart.findIndex(cartItem => cartItem.name === item.name);

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantity += 1;
        } else {
            cart.push({
                id: item.item_id,
                name: item.name,
                price: `₱${item.price}`,
                quantity: 1
            });
        }

        localStorage.setItem('cartItems', JSON.stringify(cart));
        alert("Item added to cart!");
        updateCartIconCount();
        closeOverlay();
    }

    function generateItemId(itemName) {
        return itemName.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
    }
});

function closeOverlay() {
    const overlay = document.getElementById("addToCartOverlay");
    if (overlay) {
        overlay.style.display = "none";
    }
}