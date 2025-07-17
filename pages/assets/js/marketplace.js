document.addEventListener('DOMContentLoaded', function () {
    // Ensure we only run once
    if (window.marketplaceInitialized) {
        console.log('Marketplace already initialized, skipping...');
        return;
    }
    window.marketplaceInitialized = true;

    // Only run on marketplace page
    if (!document.getElementById('marketplaceGrid')) {
        console.log('Not on marketplace page, skipping initialization');
        return;
    }

    const addItemBtn = document.getElementById('addItemBtn');
    const addItemModal = document.getElementById('addItemModal');
    const closeAddItemModal = document.getElementById('closeAddItemModal');
    const addItemForm = document.getElementById('addItemForm');
    const marketplaceGrid = document.getElementById('marketplaceGrid');
    const itemDescriptionModal = document.getElementById('itemDescriptionModal');
    const closeDescriptionModal = document.getElementById('closeDescriptionModal');

    // Track submission state
    let isSubmitting = false;

    // Initialize event listeners
    initializeEventListeners();
    attachGridEventListeners();

    function initializeEventListeners() {
        if (addItemBtn) {
            addItemBtn.addEventListener('click', handleAddItemClick);
        }

        if (closeAddItemModal) {
            closeAddItemModal.addEventListener('click', closeModal);
        }

        if (addItemForm) {
            addItemForm.addEventListener('submit', handleFormSubmission);
        }

        if (closeDescriptionModal) {
            closeDescriptionModal.addEventListener('click', () => {
                itemDescriptionModal.style.display = 'none';
            });
        }

        // Modal backdrop click
        window.addEventListener('click', function (event) {
            if (event.target === addItemModal) {
                closeModal();
            }
            if (event.target === itemDescriptionModal) {
                itemDescriptionModal.style.display = 'none';
            }
        });
    }

    function handleAddItemClick(e) {
        e.preventDefault();
        
        // Use existing session check handler
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
    }

    function handleFormSubmission(event) {
        event.preventDefault();
        
        if (isSubmitting) return;
        isSubmitting = true;

        const submitButton = addItemForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Adding Item...';

        const formData = new FormData(addItemForm);
        
        // First upload image using existing upload.handler.php
        const imageFile = formData.get('image');
        if (imageFile && imageFile.size > 0) {
            uploadImageThenCreateItem(formData, imageFile);
        } else {
            createItem(formData, null);
        }
    }

    function uploadImageThenCreateItem(formData, imageFile) {
        const imageFormData = new FormData();
        imageFormData.append('image', imageFile);

        // Use existing upload.handler.php
        fetch('../handlers/upload.handler.php', {
            method: 'POST',
            body: imageFormData
        })
        .then(response => response.json())
        .then(uploadResult => {
            if (uploadResult.success) {
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
    }

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

        // Use existing item.handler.php
        fetch('../handlers/item.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(itemData)
        })
        .then(response => response.json())
        .then(result => {
            resetSubmissionState();

            if (result.success) {
                alert('Item added successfully!');
                closeModal();
                
                // Reload the page to show the new item (simple approach)
                window.location.reload();
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

    function attachGridEventListeners() {
        // Use event delegation for dynamically added content
        marketplaceGrid.addEventListener('click', function(event) {
            if (event.target.classList.contains('more-info-btn')) {
                handleMoreInfoClick(event);
            } else if (event.target.classList.contains('buy-now-btn')) {
                handleBuyNowClick(event);
            }
        });
    }

    function handleMoreInfoClick(event) {
        event.preventDefault();
        
        const card = event.target.closest('.product-card');
        const itemName = card.dataset.name;
        const itemDescription = card.dataset.description;

        document.getElementById('descriptionModalTitle').textContent = itemName;
        document.getElementById('descriptionModalText').textContent = itemDescription;
        itemDescriptionModal.style.display = 'flex';
    }

    function handleBuyNowClick(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        
        const button = event.target;
        const itemId = button.getAttribute('data-item-id');
        const itemName = button.getAttribute('data-item-name');
        const itemPrice = parseFloat(button.getAttribute('data-item-price'));
        
        console.log('Buy Now clicked:', { itemId, itemName, itemPrice });

        // Validate data
        if (!itemId || !itemName || isNaN(itemPrice)) {
            console.error('Invalid item data:', { itemId, itemName, itemPrice });
            alert('Error: Invalid item data');
            return;
        }

        // Use existing cart.handler.php with proper data
        fetch('../handlers/cart.handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                item_id: parseInt(itemId),
                quantity: 1
            }),
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Cart response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Cart response data:', data);
            if (data.success) {
                alert(`${itemName} added to cart!`);
                // Use existing cart count update function from script.js
                if (typeof updateCartIconCount === 'function') {
                    updateCartIconCount();
                }
            } else {
                console.error('Cart error:', data);
                alert("Failed to add item to cart: " + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            alert("Error adding item to cart. Please try again.");
        });
    }

    function closeModal() {
        addItemModal.style.display = 'none';
        addItemForm.reset();
        resetSubmissionState();
    }

    function resetSubmissionState() {
        isSubmitting = false;
        const submitButton = addItemForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Add Item';
        }
    }
});