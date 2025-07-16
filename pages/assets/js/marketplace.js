document.addEventListener('DOMContentLoaded', function () {
    const addItemBtn = document.getElementById('addItemBtn');
    const addItemModal = document.getElementById('addItemModal');
    const closeAddItemModal = document.getElementById('closeAddItemModal');
    const addItemForm = document.getElementById('addItemForm');
    const marketplaceGrid = document.getElementById('marketplaceGrid');

    const itemDescriptionModal = document.getElementById('itemDescriptionModal');
    const closeDescriptionModal = document.getElementById('closeDescriptionModal');
    const descriptionModalTitle = document.getElementById('descriptionModalTitle');
    const descriptionModalText = document.getElementById('descriptionModalText');

    addItemBtn.addEventListener('click', function () {
        // Check if user is logged in
        fetch('../handlers/check-session.handler.php')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.logged_in) {
                    addItemModal.style.display = 'flex';
                } else {
                    alert('You must be logged in to add items to the marketplace.');
                }
            })
            .catch(error => {
                console.error('Session check failed:', error);
                alert('Please log in to add items.');
            });
    });

    closeAddItemModal.addEventListener('click', function () {
        addItemModal.style.display = 'none';
        addItemForm.reset();
    });

    window.addEventListener('click', function (event) {
        if (event.target == addItemModal) {
            addItemModal.style.display = 'none';
            addItemForm.reset();
        }
        if (event.target == itemDescriptionModal) {
            itemDescriptionModal.style.display = 'none';
        }
    });

    addItemForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const submitButton = addItemForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Adding Item...';

        const formData = new FormData(addItemForm);
        
        // First upload the image
        const imageFile = formData.get('image');
        if (imageFile && imageFile.size > 0) {
            const imageFormData = new FormData();
            imageFormData.append('image', imageFile);

            fetch('../handlers/upload.handler.php', {
                method: 'POST',
                body: imageFormData
            })
            .then(response => response.json())
            .then(uploadResult => {
                if (uploadResult.success) {
                    // Image uploaded successfully, now create the item
                    createItem(formData, uploadResult.image_url);
                } else {
                    alert('Image upload failed: ' + uploadResult.message);
                    submitButton.disabled = false;
                    submitButton.textContent = 'Add Item';
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                alert('Failed to upload image. Please try again.');
                submitButton.disabled = false;
                submitButton.textContent = 'Add Item';
            });
        } else {
            // No image provided, create item without image
            createItem(formData, null);
        }
    });

    function createItem(formData, imageUrl) {
        const itemData = {
            name: formData.get('name'),
            description: formData.get('description'),
            price: parseFloat(formData.get('price')),
            category: formData.get('category'),
            stock_quantity: parseInt(formData.get('stock_quantity')),
            image_url: imageUrl,
            source: 'marketplace'
        };

        fetch('../handlers/item.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(itemData)
        })
        .then(response => response.json())
        .then(result => {
            const submitButton = addItemForm.querySelector('button[type="submit"]');
            submitButton.disabled = false;
            submitButton.textContent = 'Add Item';

            if (result.success) {
                alert('Item added successfully!');
                addItemModal.style.display = 'none';
                addItemForm.reset();
                
                // Instead of reloading, dynamically add the new item
                addNewItemToGrid(itemData, result.item_id);
            } else {
                alert('Failed to add item: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error creating item:', error);
            alert('Failed to add item. Please try again.');
            const submitButton = addItemForm.querySelector('button[type="submit"]');
            submitButton.disabled = false;
            submitButton.textContent = 'Add Item';
        });
    }

    function addNewItemToGrid(itemData, itemId) {
        // Remove "No items available" message if it exists
        const noItemsMessage = marketplaceGrid.querySelector('p');
        if (noItemsMessage && noItemsMessage.textContent.includes('No items available')) {
            noItemsMessage.remove();
        }

        // Create new product card element
        const productCard = document.createElement('div');
        productCard.className = 'product-card new-item'; // Add new-item class for animation
        productCard.setAttribute('data-name', itemData.name);
        productCard.setAttribute('data-price', itemData.price.toFixed(2));
        productCard.setAttribute('data-description', itemData.description);
        productCard.setAttribute('data-item-id', itemId);

        // Use the actual uploaded image URL, or fallback to placeholder
        let imageUrl;
        if (itemData.image_url && itemData.image_url !== null && itemData.image_url !== '') {
            // Use the uploaded image
            imageUrl = itemData.image_url;
        } else {
            // Use placeholder with theme colors
            const placeholderText = encodeURIComponent(itemData.name.substring(0, 8));
            imageUrl = `https://via.placeholder.com/150x150/1C1C1C/DA6015?text=${placeholderText}`;
        }

        productCard.innerHTML = `
            <div class="item-image">
                <img src="${imageUrl}" 
                     alt="${itemData.name}" 
                     loading="lazy"
                     onerror="this.src='https://via.placeholder.com/150x150/1C1C1C/DA6015?text=No+Image'">
                <div class="item-overlay">
                    <p class="item-name">${itemData.name}</p>
                    <p class="item-price">₱${itemData.price.toFixed(2)}</p>
                </div>
            </div>
            <div class="item-bottom-actions">
                <button class="more-info-btn">More Info</button>
                <button class="buy-now-btn" 
                        data-item-name="${itemData.name}" 
                        data-item-price="${itemData.price}"
                        data-item-id="${itemId}">Buy Now</button>
            </div>
        `;

        // Add the new card to the beginning of the grid (most recent first)
        marketplaceGrid.insertBefore(productCard, marketplaceGrid.firstChild);

        // Reattach event listeners for the new card
        attachMoreInfoListeners();
        
        // Trigger the CSS animation by removing the new-item class after animation completes
        setTimeout(() => {
            productCard.classList.remove('new-item');
        }, 500);

        // Scroll to show the new item (helpful on mobile)
        productCard.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'nearest' 
        });
    }

    function attachMoreInfoListeners() {
        document.querySelectorAll('.more-info-btn').forEach(button => {
            button.onclick = function () {
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

    closeDescriptionModal.addEventListener('click', function () {
        itemDescriptionModal.style.display = 'none';
    });
});