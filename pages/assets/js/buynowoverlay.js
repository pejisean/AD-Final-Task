function closeBuyNowOverlay() {
  const buyNowOverlay = document.getElementById("buyNowOverlay");
  if (buyNowOverlay) {
    buyNowOverlay.style.display = "none";
    buyNowOverlay.classList.remove("active");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const buyNowButtons = document.querySelectorAll(".buy-now-btn");
  const overlay = document.getElementById("buyNowOverlay");
  const itemNameEl = document.getElementById("receiptItemName");
  const itemPriceEl = document.getElementById("receiptItemPrice");
  const totalPriceEl = document.getElementById("receiptTotalPrice");
  const ipAddressEl = document.getElementById("receiptIPAddress");
  const proceedPaymentButton = document.getElementById("proceedPaymentButton");

  if (!overlay) {
    console.error("Buy Now overlay element not found");
    return;
  }

  // Use direct event binding for the close button
  const closeButton = document.getElementById("closeBuyNowOverlayBtn");
  if (closeButton) {
    closeButton.addEventListener("click", closeBuyNowOverlay);
  }


  // Generate random IP address (simulating secure outpost location)
  function generateRandomIP() {
    return Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');
  }

  let currentItem = {};

  buyNowButtons.forEach(button => {
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
        ip: ip
      };

      overlay.style.display = "flex";
    });
  });

  if (proceedPaymentButton) {
    proceedPaymentButton.addEventListener("click", () => {
      const loggedInCodename = localStorage.getItem('loggedInCodename');
      if (!loggedInCodename) {
        alert("You must be logged in to proceed with payment.");
        closeBuyNowOverlay();
        return;
      }

      let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
      cart.push(currentItem);
      localStorage.setItem('cartItems', JSON.stringify(cart));
      // Redirect to cart and trigger checkout overlay
      window.location.href = '/pages/cart.php?checkout=1';
    });
  }
});

