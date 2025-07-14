document.addEventListener("DOMContentLoaded", () => {
  const buyNowButtons = document.querySelectorAll(".buy-now-btn");
  const overlay = document.getElementById("buyNowOverlay");
  const itemNameEl = document.getElementById("receiptItemName");
  const itemPriceEl = document.getElementById("receiptItemPrice");
  const totalPriceEl = document.getElementById("receiptTotalPrice");
  const ipAddressEl = document.getElementById("receiptIPAddress");
  const closeButton = document.getElementById("closeBuyNowOverlayBtn"); // Changed this line to target the specific ID

  // Get the proceed payment button
  const proceedPaymentButton = document.getElementById("proceedPaymentButton");

  if (!overlay) {
    console.error("Buy Now overlay element not found");
    return;
  }

  // Generate random IP address (simulating secure outpost location)
  function generateRandomIP() {
    return Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');
  }

  // Store current item details when the overlay is shown
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

      // Store the item details
      currentItem = {
        name: itemName,
        price: parseFloat(itemPrice).toFixed(2),
        ip: ip
      };

      overlay.style.display = "flex";
    });
  });

  if (closeButton) {
    closeButton.addEventListener("click", closeOverlay);
  }

  // Modified: Add confirmation button handler
  if (proceedPaymentButton) {
    proceedPaymentButton.addEventListener("click", () => {
      // Here you would implement your "add to cart" logic.
      // This could involve:
      // 1. Sending the currentItem data to a server using fetch/XMLHttpRequest.
      // 2. Storing the item in local storage/session storage for a client-side cart.

      console.log("Adding to cart:", currentItem); // For demonstration

      // Example: If you were to send data to a server (requires a backend endpoint)
      /*
      fetch('add_to_cart.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify(currentItem),
      })
      .then(response => response.json())
      .then(data => {
          console.log('Success:', data);
          // After successfully adding to cart, redirect to history.php
          window.location.href = 'history.php';
      })
      })
      .catch((error) => {
          console.error('Error:', error);
          alert("Failed to add item to cart. Please try again.");
      });
      */

      // For a simple client-side example, you might store it in localStorage:
      let cart = JSON.parse(localStorage.getItem('cartItems')) || [];
      cart.push(currentItem);
      localStorage.setItem('cartItems', JSON.stringify(cart));
      alert("Item added to cart!"); // Or a more user-friendly message

      // Redirect to history.php

      closeOverlay();
    });
  }
});

// Close overlay function
function closeOverlay() {
  document.getElementById("buyNowOverlay").style.display = "none";
}