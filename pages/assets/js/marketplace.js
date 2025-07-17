(function() {
    'use strict';
    
    // Prevent multiple executions
    if (window.marketplaceInitialized) {
        console.log('Marketplace already initialized, preventing duplicate execution');
        return;
    }

    // Only run on marketplace page
    const isMarketplacePage = window.location.pathname.includes('marketplace.php');
    const hasMarketplaceGrid = document.getElementById('marketplaceGrid');
    
    if (!isMarketplacePage || !hasMarketplaceGrid) {
        console.log('Not on marketplace page, skipping marketplace.js initialization');
        return;
    }

    console.log('Initializing marketplace functionality...');
    window.marketplaceInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        const addItemBtn = document.getElementById('addItemBtn');
        const addItemModal = document.getElementById('addItemModal');
        const closeAddItemModal = document.getElementById('closeAddItemModal');
        const addItemForm = document.getElementById('addItemForm');
        const marketplaceGrid = document.getElementById('marketplaceGrid');
        const itemDescriptionModal = document.getElementById('itemDescriptionModal');
        const closeDescriptionModal = document.getElementById('closeDescriptionModal');

        let isSubmitting = false;

        // Initialize all event listeners
        if (addItemBtn) {
            addItemBtn.addEventListener('click', function(e) {
                e.preventDefault();
                handleAddItem();
            });
        }

        if (closeAddItemModal) {
            closeAddItemModal.addEventListener('click', closeModal);
        }

        if (addItemForm) {
            addItemForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!isSubmitting) {
                    handleFormSubmission();
                }
            });
        }

        if (closeDescriptionModal) {
            closeDescriptionModal.addEventListener('click', function() {
                itemDescriptionModal.style.display = 'none';
            });
        }

        // Modal backdrop clicks
        window.addEventListener('click', function(event) {
            if (event.target === addItemModal) {
                closeModal();
            }
            if (event.target === itemDescriptionModal) {
                itemDescriptionModal.style.display = 'none';
            }
        });

        // Grid event delegation
        if (marketplaceGrid) {
            marketplaceGrid.addEventListener('click', function(event) {
                if (event.target.classList.contains('more-info-btn')) {
                    handleMoreInfo(event);
                } else if (event.target.classList.contains('buy-now-btn')) {
                    handleBuyNow(event);
                }
            });
        }

        function handleAddItem() {
            fetch('../handlers/check-session.handler.php', {
                signal: AbortSignal.timeout(5000)
            })
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

        function handleFormSubmission() {
            isSubmitting = true;
            const submitButton = addItemForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Adding Item...';

            const formData = new FormData(addItemForm);
            const imageFile = formData.get('image');

            if (imageFile && imageFile.size > 0) {
                uploadImage(formData, imageFile);
            } else {
                createItem(formData, null);
            }
        }

        function uploadImage(formData, imageFile) {
            const imageFormData = new FormData();
            imageFormData.append('image', imageFile);

            fetch('../handlers/upload.handler.php', {
                method: 'POST',
                body: imageFormData,
                signal: AbortSignal.timeout(30000)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    createItem(formData, result.image_url);
                } else {
                    alert('Upload failed: ' + result.message);
                    resetForm();
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                alert('Upload failed. Please try again.');
                resetForm();
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

            fetch('../handlers/item.handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(itemData),
                signal: AbortSignal.timeout(10000)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Item added successfully!');
                    closeModal();
                    window.location.reload();
                } else {
                    alert('Failed to add item: ' + result.message);
                }
                resetForm();
            })
            .catch(error => {
                console.error('Error creating item:', error);
                alert('Failed to add item. Please try again.');
                resetForm();
            });
        }

        function handleMoreInfo(event) {
            event.preventDefault();
            const card = event.target.closest('.product-card');
            const itemName = card.dataset.name;
            const itemDescription = card.dataset.description;

            document.getElementById('descriptionModalTitle').textContent = itemName;
            document.getElementById('descriptionModalText').textContent = itemDescription;
            itemDescriptionModal.style.display = 'flex';
        }

        function handleBuyNow(event) {
            event.preventDefault();
            
            const button = event.target;
            const itemId = parseInt(button.getAttribute('data-item-id'));
            const itemName = button.getAttribute('data-item-name');
            
            if (!itemId || !itemName) {
                alert('Error: Invalid item data');
                return;
            }

            button.disabled = true;
            button.textContent = 'Adding...';

            fetch('../handlers/cart.handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: 1
                }),
                credentials: 'same-origin',
                signal: AbortSignal.timeout(10000)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`${itemName} added to cart!`);
                    // Only update cart count once
                    if (typeof updateCartIconCount === 'function') {
                        updateCartIconCount();
                    }
                } else {
                    alert('Failed to add to cart: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Cart error:', error);
                alert('Error adding to cart. Please try again.');
            })
            .finally(() => {
                button.disabled = false;
                button.textContent = 'Buy Now';
            });
        }

        function closeModal() {
            addItemModal.style.display = 'none';
            addItemForm.reset();
            resetForm();
        }

        function resetForm() {
            isSubmitting = false;
            const submitButton = addItemForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Add Item';
            }
        }
    });
})();