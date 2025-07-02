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

    addItemBtn.addEventListener('click', function() {
        addItemModal.style.display = 'flex';
    });

    closeAddItemModal.addEventListener('click', function() {
        addItemModal.style.display = 'none';
        addItemForm.reset();
    });

    window.addEventListener('click', function(event) {
        if (event.target == addItemModal) {
            addItemModal.style.display = 'none';
            addItemForm.reset();
        }
        if (event.target == itemDescriptionModal) {
            itemDescriptionModal.style.display = 'none';
        }
    });

    addItemForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const itemName = document.getElementById('itemName').value;
        const itemPrice = parseFloat(document.getElementById('itemPrice').value).toFixed(2);
        const itemImageInput = document.getElementById('itemImage');
        const itemDescription = document.getElementById('itemDescription').value;

        // Handle file upload
        let itemImageUrl = 'https://via.placeholder.com/150x100';
        if (itemImageInput.files.length > 0) {
            const file = itemImageInput.files[0];
            if (file.type === 'image/png') {
                itemImageUrl = URL.createObjectURL(file);
            } else {
                alert('Please upload a PNG image file.');
                return;
            }
        }

        // Create new product card
        const newProductCard = document.createElement('div');
        newProductCard.classList.add('product-card');
        newProductCard.dataset.name = itemName;
        newProductCard.dataset.price = itemPrice;
        newProductCard.dataset.description = itemDescription;

        newProductCard.innerHTML = `
            <div class="item-image">
                <img src="${itemImageUrl}" alt="${itemName}">
            </div>
            <div class="item-details">
                <p class="item-name">${itemName}</p>
                <p class="item-price">${itemPrice}</p>
            </div>
            <div class="item-actions">
                <button class="more-info-btn">More Info</button>
            </div>
        `;

        marketplaceGrid.prepend(newProductCard);

        addItemModal.style.display = 'none';
        addItemForm.reset();

        attachMoreInfoListeners();
    });

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

    attachMoreInfoListeners();

    closeDescriptionModal.addEventListener('click', function() {
        itemDescriptionModal.style.display = 'none';
    });
});