document.addEventListener('DOMContentLoaded', function() {
    const addItemBtn = document.getElementById('addItemBtn');
    const addItemModal = document.getElementById('addItemModal');
    const closeAddItemModal = document.getElementById('closeAddItemModal');
    const addItemForm = document.getElementById('addItemForm');
    const marketplaceGrid = document.getElementById('marketplaceGrid');

    const itemDescriptionModal = document.getElementById('itemDescriptionModal');
    const closeDescriptionModal = document.getElementById('closeDescriptionModal');
    const descriptionModalTitle = document.getElementById('descriptionModalTitle');
    const descriptionModalText = document.getElementById('descriptionModalText');

    // Show Add Item Modal
    addItemBtn.addEventListener('click', function() {
        addItemModal.style.display = 'flex';
    });

    // Close Add Item Modal
    closeAddItemModal.addEventListener('click', function() {
        addItemModal.style.display = 'none';
        addItemForm.reset(); // Clear form on close
    });

    // Close modal if clicked outside
    window.addEventListener('click', function(event) {
        if (event.target == addItemModal) {
            addItemModal.style.display = 'none';
            addItemForm.reset();
        }
        if (event.target == itemDescriptionModal) {
            itemDescriptionModal.style.display = 'none';
        }
    });

    // Handle Add Item Form Submission
    addItemForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const itemName = document.getElementById('itemName').value;
        const itemPrice = parseFloat(document.getElementById('itemPrice').value).toFixed(2);
        const itemCondition = document.getElementById('itemCondition').value;
        const itemStatus = document.getElementById('itemStatus').value;
        const itemPriceChange = document.getElementById('itemPriceChange').value;
        const itemImage = document.getElementById('itemImage').value;
        const itemDescription = document.getElementById('itemDescription').value;

        // Create new product card
        const newProductCard = document.createElement('div');
        newProductCard.classList.add('product-card');
        newProductCard.dataset.name = itemName;
        newProductCard.dataset.price = itemPrice;
        newProductCard.dataset.description = itemDescription;

        newProductCard.innerHTML = `
            <div class="item-header">
                <span class="item-condition">${itemCondition || 'N/A'}</span>
            </div>
            <div class="item-image">
                <img src="${itemImage || 'https://via.placeholder.com/150x100'}" alt="${itemName}">
            </div>
            <div class="item-details">
                <p class="item-name">${itemName}</p>
                <p class="item-price">${itemPrice}<span class="price-change ${itemPriceChange.includes('+') ? 'positive' : (itemPriceChange.includes('-') ? 'negative' : '')}">${itemPriceChange || ''}</span></p>
            </div>
            <div class="item-actions">
                <span class="item-status ${itemStatus}">${itemStatus.charAt(0).toUpperCase() + itemStatus.slice(1)}</span>
                <button class="more-info-btn">More Info</button>
            </div>
        `;

        marketplaceGrid.prepend(newProductCard); // Add new card to the beginning of the grid

        addItemModal.style.display = 'none'; // Hide modal
        addItemForm.reset(); // Reset form

        // Re-attach event listener for the new "More Info" button
        attachMoreInfoListeners();
    });

    // Function to attach More Info button listeners
    function attachMoreInfoListeners() {
        document.querySelectorAll('.more-info-btn').forEach(button => {
            button.onclick = function() {
                const card = this.closest('.product-card');
                const itemName = card.dataset.name;
                const itemDescription = card.dataset.description;

                descriptionModalTitle.textContent = itemName;
                descriptionModalText.textContent = itemDescription;
                itemDescriptionModal.style.display = 'flex';
            };
        });
    }

    // Attach listeners initially for existing cards
    attachMoreInfoListeners();

    // Close Item Description Modal
    closeDescriptionModal.addEventListener('click', function() {
        itemDescriptionModal.style.display = 'none';
    });
});