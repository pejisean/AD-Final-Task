(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        // Add debug logging
        console.log('Marketplace script loaded');

        // Get elements with better error checking
        const addItemBtn = document.getElementById('addItemBtn');
        const addItemModal = document.getElementById('addItemModal');
        const closeAddItemModal = document.getElementById('closeAddItemModal');
        const addItemForm = document.getElementById('addItemForm');
        const marketplaceGrid = document.getElementById('marketplaceGrid');
        const itemDescriptionModal = document.getElementById('itemDescriptionModal');
        const closeDescriptionModal = document.getElementById('closeDescriptionModal');

        // Check if required elements exist
        if (!addItemBtn || !addItemModal || !addItemForm) {
            console.error('Required marketplace elements not found');
            return;
        }

        let isSubmitting = false;

        // Initialize all event listeners
        addItemBtn.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Add item button clicked');
            handleAddItem();
        });

        if (closeAddItemModal) {
            closeAddItemModal.addEventListener('click', closeModal);
        }

        addItemForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Form submitted');
            if (!isSubmitting) {
                handleFormSubmission();
            }
        });

        if (closeDescriptionModal) {
            closeDescriptionModal.addEventListener('click', function () {
                itemDescriptionModal.style.display = 'none';
            });
        }

        // Modal backdrop clicks
        window.addEventListener('click', function (event) {
            if (event.target === addItemModal) {
                closeModal();
            }
            if (event.target === itemDescriptionModal) {
                itemDescriptionModal.style.display = 'none';
            }
        });

        // Grid event delegation
        if (marketplaceGrid) {
            marketplaceGrid.addEventListener('click', function (event) {
                if (event.target.classList.contains('more-info-btn')) {
                    handleMoreInfo(event);
                } else if (event.target.classList.contains('buy-now-btn')) {
                    handleBuyNow(event);
                }
            });
        }

        function handleAddItem() {
            console.log('Checking session...');

            // Always check server session first for security
            fetch('../handlers/check-session.handler.php', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    console.log('Session response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Session data:', data);

                    if (data.success && data.logged_in) {
                        console.log('User logged in via session, opening modal');
                        // Sync localStorage with server session
                        localStorage.setItem('loggedInCodename', data.user.username);
                        addItemModal.style.display = 'flex';
                    } else {
                        console.log('User not logged in via session');
                        // Clear localStorage if server says not logged in
                        localStorage.removeItem('loggedInCodename');
                        alert('You must login first before adding an item');
                        window.location.href = 'login.php';
                    }
                })
                .catch(error => {
                    console.error('Session check failed:', error);
                    localStorage.removeItem('loggedInCodename');
                    alert('Session check failed. Please log in again.');
                    window.location.href = 'login.php';
                });
        }

        function handleFormSubmission() {
            console.log('Starting form submission...');
            isSubmitting = true;
            const submitButton = addItemForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Adding Item...';
            }

            const formData = new FormData(addItemForm);

            // Log form data for debugging
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            const imageFile = formData.get('image');

            if (imageFile && imageFile.size > 0) {
                console.log('Uploading image first...');
                uploadImage(formData, imageFile);
            } else {
                console.log('Creating item without image...');
                createItem(formData, null);
            }
        }

        function uploadImage(formData, imageFile) {
            const uploadFormData = new FormData();
            uploadFormData.append('image', imageFile);
            uploadFormData.append('type', 'marketplace');

            console.log('Uploading image...');
            console.log('Image file:', imageFile);
            console.log('Image file name:', imageFile.name);
            console.log('Image file size:', imageFile.size);
            console.log('Image file type:', imageFile.type);

            fetch('../handlers/upload.handler.php', {
                method: 'POST',
                body: uploadFormData,
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Upload response status:', response.status);
                    console.log('Upload response headers:', response.headers);
                    return response.text();
                })
                .then(text => {
                    console.log('Raw upload response:', text);
                    try {
                        const result = JSON.parse(text);
                        console.log('Parsed upload result:', result);

                        if (result.success) {
                            console.log('Image uploaded successfully:', result.data.url);
                            console.log('Full server path:', result.data.full_path);

                            // Test if the file actually exists by trying to access it
                            const testImg = new Image();
                            testImg.onload = function () {
                                console.log('Image is accessible via web path');
                            };
                            testImg.onerror = function () {
                                console.error('Image is NOT accessible via web path');
                            };
                            testImg.src = '../' + result.data.url;

                            createItem(formData, result.data.url);
                        } else {
                            console.error('Upload failed:', result.message);
                            alert('Failed to upload image: ' + result.message);
                            resetForm();
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Response text:', text);
                        alert('Server error during image upload.');
                        resetForm();
                    }
                })
                .catch(error => {
                    console.error('Error uploading image:', error);
                    alert('Failed to upload image: ' + error.message);
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

            console.log('Creating item with data:', itemData);

            fetch('../handlers/item.handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(itemData),
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Create item response status:', response.status);
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response:', text);
                    try {
                        const result = JSON.parse(text);
                        console.log('Parsed result:', result);

                        if (result.success) {
                            alert('Item added successfully!');
                            closeModal();
                            // Refresh the page to show the new item
                            window.location.reload();
                        } else {
                            // Show detailed error information
                            console.error('Creation failed:', result);
                            let errorMessage = 'Failed to add item: ' + (result.message || 'Unknown error');

                            if (result.debug_data) {
                                console.error('Debug data:', result.debug_data);
                            }
                            if (result.stack_trace) {
                                console.error('Stack trace:', result.stack_trace);
                            }

                            alert(errorMessage);
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Response text:', text);
                        alert('Server error. Check console for details.');
                    }
                    resetForm();
                })
                .catch(error => {
                    console.error('Error creating item:', error);
                    alert('Failed to add item: ' + error.message);
                    resetForm();
                });
        }

        function handleMoreInfo(event) {
            event.preventDefault();

            const button = event.target;
            const itemCard = button.closest('.marketplace-item');
            const itemName = itemCard.querySelector('.item-name').textContent;
            const itemPrice = itemCard.querySelector('.item-price').textContent;
            const itemDescription = itemCard.dataset.description || 'No description available';

            // Set modal content
            document.getElementById('descriptionModalTitle').textContent = itemName + ' - ' + itemPrice;
            document.getElementById('descriptionModalText').textContent = itemDescription;

            // Show modal
            document.getElementById('itemDescriptionModal').style.display = 'flex';
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