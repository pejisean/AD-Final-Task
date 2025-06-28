document.addEventListener('DOMContentLoaded', function() {
    
    const mainSortDropdown = document.querySelector('#sort-by-main');

    if (!mainSortDropdown) {
        return;
    }

    const newArrivalsGrid = document.querySelector('#new-arrivals-grid');
    const topSellersGrid = document.querySelector('#top-sellers-grid');

    if (!newArrivalsGrid || !topSellersGrid) {
        return;
    }

    const allCards = [
        ...newArrivalsGrid.querySelectorAll('.product-card'),
        ...topSellersGrid.querySelectorAll('.product-card')
    ];

    const originalOrder = [...allCards];

    const newArrivalsCapacity = newArrivalsGrid.children.length;

    mainSortDropdown.addEventListener('change', function() {
        const sortBy = this.value;
        let sortedProducts;

        const listToSort = [...originalOrder];

        switch (sortBy) {
            case 'price-asc':
                sortedProducts = listToSort.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
                break;
            case 'price-desc':
                sortedProducts = listToSort.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
                break;
            default:
                sortedProducts = originalOrder;
                break;
        }

        newArrivalsGrid.innerHTML = '';
        topSellersGrid.innerHTML = '';

        sortedProducts.forEach((product, index) => {
            if (index < newArrivalsCapacity) {
                newArrivalsGrid.appendChild(product);
            } else {
                topSellersGrid.appendChild(product);
            }
        });
    });
});

        function toggleMenu() {
            var menu = document.getElementById("dropdownMenu");
            if (menu.style.display === "flex") {
                menu.style.display = "none";
            } else {
                menu.style.display = "flex";
            }
        }