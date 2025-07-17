document.addEventListener('DOMContentLoaded', function () {
    // Ensure we only run once
    if (window.marketplaceInitialized) {
        console.log('Marketplace already initialized, skipping...');
        return;
    }
    window.marketplaceInitialized = true;

    const addItemBtn = document.getElementById('addItemBtn');
    const addItemModal = document.getElementById('addItemModal');
    const closeAddItemModal = document.getElementById('closeAddItemModal');
    const addItemForm = document.getElementById('addItemForm');
    const marketplaceGrid = document.getElementById('marketplaceGrid');

    const itemDescriptionModal = document.getElementById('itemDescriptionModal');
    const closeDescriptionModal = document.getElementById('closeDescriptionModal');
    const descriptionModalTitle = document.getElementById('descriptionModalTitle');
    const descriptionModalText = document.getElementById('descriptionModalText');

    // Track submission state to prevent double submissions
    let isSubmitting = false;
    let formSubmissionCount = 0; // Additional tracking

    // Remove any existing event listeners first
    if (addItemBtn) {
        addItemBtn.replaceWith(addItemBtn.cloneNode(true));
        const newAddItemBtn = document.getElementById('addItemBtn');
        
        newAddItemBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            console.log('Add item button clicked');
            
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
    }

    if (closeAddItemModal) {
        closeAddItemModal.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            addItemModal.style.display = 'none';
            addItemForm.reset();
            resetSubmissionState();
        });
    }

    window.addEventListener('click', function (event) {
        if (event.target == addItemModal) {
            addItemModal.style.display = 'none';
            addItemForm.reset();
            resetSubmissionState();
        }
        if (event.target == itemDescriptionModal) {
            itemDescriptionModal.style.display = 'none';
        }
    });

    // Remove existing form listeners and add new one
    if (addItemForm) {
        // Clone form to remove all existing listeners
        const newForm = addItemForm.cloneNode(true);
        addItemForm.parentNode.replaceChild(newForm, addItemForm);
        const form = document.getElementById('addItemForm');
        
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            
            formSubmissionCount++;
            console.log(`Form submission attempt #${formSubmissionCount}`);

            // Prevent double submission
            if (isSubmitting) {
                console.log('Submission already in progress, ignoring...');
                return false;
            }

            isSubmitting = true;
            console.log('Starting form submission...');

            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Adding Item...';
            }

            const formData = new FormData(form);
            
            // First upload the image
            const imageFile = formData.get('image');
            if (imageFile && imageFile.size > 0) {
                console.log('Uploading image...');
                const imageFormData = new FormData();
                imageFormData.append('image', imageFile);

                fetch('../handlers/upload.handler.php', {
                    method: 'POST',
                    body: imageFormData
                })
                .then(response => response.json())
                .then(uploadResult => {
                    console.log('Upload result:', uploadResult);
                    if (uploadResult.success) {
                        // Image uploaded successfully, now create the item
                        createItem(formData, uploadResult.image_url);
                    } else {
                        alert('Image upload failed: ' + uploadResult.message);
                        resetSubmissionState();
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Failed to upload image. Please try again.');
                    resetSubmissionState();
                });
            } else {
                console.log('No image provided, creating item without image...');
                // No image provided, create item without image
                createItem(formData, null);
            }
            
            return false; // Ensure form doesn't submit normally
        });
    }

    function resetSubmissionState() {
        console.log('Resetting submission state...');
        isSubmitting = false;
        const submitButton = document.querySelector('#addItemForm button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Add Item';
        }
    }

    function createItem(formData, imageUrl) {
        console.log('Creating item with image URL:', imageUrl);
        
        const itemData = {
            name: formData.get('name'),
            description: formData.get('description'),
            price: parseFloat(formData.get('price')),
            category: formData.get('category'),
            stock_quantity: parseInt(formData.get('stock_quantity')),
            image_url: imageUrl,
            source: 'marketplace'
        };

        console.log('Item data:', itemData);

        fetch('../handlers/item.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(itemData)
        })
        .then(response => {
            console.log('Item creation response status:', response.status);
            return response.json();
        })
        .then(result => {
            console.log('Item creation result:', result);
            resetSubmissionState();

            if (result.success) {
                alert('Item added successfully!');
                document.getElementById('addItemModal').style.display = 'none';
                document.getElementById('addItemForm').reset();
                
                // Instead of reloading, dynamically add the new item
                addNewItemToGrid(itemData, result.item_id);
            } else {
                alert('Failed to add item: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error creating item:', error);
            alert('Failed to add item. Please try again.');
            resetSubmissionState();
        });
    }

    function addNewItemToGrid(itemData, itemId) {
        console.log('Adding new item to grid:', itemData);
        
        // Remove "No items available" message if it exists
        const noItemsMessage = marketplaceGrid.querySelector('p');
        if (noItemsMessage && noItemsMessage.textContent.includes('No items available')) {
            noItemsMessage.remove();
        }

        // Create new product card element
        const productCard = document.createElement('div');
        productCard.className = 'product-card new-item';
        productCard.setAttribute('data-name', itemData.name);
        productCard.setAttribute('data-price', itemData.price.toFixed(2));
        productCard.setAttribute('data-description', itemData.description);
        productCard.setAttribute('data-item-id', itemId);

        // Handle image URL - use uploaded image or placeholder
        let imageUrl;
        if (itemData.image_url && itemData.image_url !== null && itemData.image_url !== '') {
            // Use the uploaded image URL as-is (it's already absolute from domain root)
            imageUrl = itemData.image_url;
        } else {
            // Use placeholder that matches the utility class format
            const placeholderText = encodeURIComponent(itemData.name.substring(0, 8));
            imageUrl = `https://via.placeholder.com/150x150/1C1C1C/DA6015?text=${placeholderText}`;
        }

        productCard.innerHTML = `
            <div class="item-image">
                <img src="${imageUrl}" 
                     alt="${itemData.name}" 
                     loading="lazy"
                     onerror="this.src='../assets/img/placeholder.jpg'">
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

        // Add the new card to the beginning of the grid
        marketplaceGrid.insertBefore(productCard, marketplaceGrid.firstChild);

        // Reattach event listeners
        attachMoreInfoListeners();
        
        // Remove animation class after animation completes
        setTimeout(() => {
            productCard.classList.remove('new-item');
        }, 500);

        // Scroll to show the new item
        productCard.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'nearest' 
        });
    }

    function attachMoreInfoListeners() {
        // Use event delegation instead of adding individual listeners
        marketplaceGrid.removeEventListener('click', handleMoreInfoClick);
        marketplaceGrid.addEventListener('click', handleMoreInfoClick);
    }

    function handleMoreInfoClick(event) {
        if (event.target.classList.contains('more-info-btn')) {
            event.preventDefault();
            event.stopImmediatePropagation();
            
            const card = event.target.closest('.product-card');
            const itemName = card.dataset.name;
            const itemDescription = card.dataset.description;

            descriptionModalTitle.textContent = itemName;
            descriptionModalText.textContent = itemDescription;
            itemDescriptionModal.style.display = 'flex';
        }
    }

    // Add Buy Now functionality for marketplace items
    function attachBuyNowListeners() {
        marketplaceGrid.removeEventListener('click', handleBuyNowClick);
        marketplaceGrid.addEventListener('click', handleBuyNowClick);
    }

    function handleBuyNowClick(event) {
        if (event.target.classList.contains('buy-now-btn')) {
            event.preventDefault();
            event.stopImmediatePropagation();
            
            const button = event.target;
            const itemId = button.getAttribute('data-item-id');
            const itemName = button.getAttribute('data-item-name');
            const itemPrice = parseFloat(button.getAttribute('data-item-price'));

            // Use existing cart handler - much simpler!
            addToCartViaHandler(itemId, itemName, itemPrice);
        }
    }

    function addToCartViaHandler(itemId, itemName, itemPrice) {
        // Use your existing cart.handler.php
        fetch('../handlers/cart.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                item_id: itemId,
                quantity: 1
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${itemName} added to cart!`);
                // Use existing cart count update function
                if (typeof updateCartIconCount === 'function') {
                    updateCartIconCount();
                }
            } else {
                alert("Failed to add item to cart: " + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            alert("Error adding item to cart. Please try again.");
        });
    }

    // Initial setup
    attachMoreInfoListeners();
    attachBuyNowListeners();

    if (closeDescriptionModal) {
        closeDescriptionModal.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            itemDescriptionModal.style.display = 'none';
        });
    }
});