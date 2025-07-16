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
        return Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');
    }

    let currentItem = {};

    addToCartButtons.forEach(button => {
        button.addEventListener("click", event => {
            event.preventDefault();

            /*
            THIS PART IS COMMENTED OUT TO ALLOW ADDING TO CART WITHOUT LOGIN

            const loggedInCodename = localStorage.getItem('loggedInCodename');
            if (!loggedInCodename) {
                alert("You must be logged in to add items to cart.");
                closeOverlay();
                return;
            }
            */

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
                ip: ip
            };

            overlay.style.display = "flex";
        });
    });

    if (proceedAddButton) {
        proceedAddButton.addEventListener("click", () => {
            const loggedInCodename = localStorage.getItem('loggedInCodename');
            if (!loggedInCodename) {
                alert("You must be logged in to proceed.");
                closeOverlay();
                return;
            }

            let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
            cart.push(currentItem);
            localStorage.setItem('cartItems', JSON.stringify(cart));
            alert("Item added to cart!");
            closeOverlay();
        });
    }
});

function closeOverlay() {
    document.getElementById("buyNowOverlay").style.display = "none";
    document.getElementById("addToCartOverlay").style.display = "none";
}