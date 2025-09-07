$(document).ready(function () {
    // Get all navigation items
    const navItems = $('.nav-item');

    // Function to remove active class from all items
    function removeActiveClass() {
        navItems.each((index, item) => {
            $(item).removeClass('bg-green-500');
            $(item).addClass('hover:bg-green-700');
        });
    }

    // Function to add active class to clicked item
    function addActiveClass(clickedItem) {
        $(clickedItem).addClass('bg-green-500');
        $(clickedItem).removeClass('hover:bg-green-700');
    }

    // Add click event listeners to all navigation items
    navItems.each((index, item) => {
        $(item).on('click', function (e) {
            e.preventDefault(); // Prevent default link behavior

            // Remove active class from all items
            removeActiveClass();

            // Add active class to clicked item
            addActiveClass($(this));

            // Save active state to localStorage
            const activeNav = $(this).data('nav');
            localStorage.setItem('activeMainNav', activeNav);
        });
    });

    // Restore main nav active state from localStorage
    const savedActiveMainNav = localStorage.getItem('activeMainNav');
    if (savedActiveMainNav) {
        // Find and activate the saved item
        const savedMainItem = navItems.filter(`[data-nav="${savedActiveMainNav}"]`);
        if (savedMainItem.length > 0) {
            removeActiveClass();
            addActiveClass(savedMainItem);
        }
    }

    // Sub Navigation Logic
    const subNavItems = $('.sub-nav-item');

    function removeSubActiveClass() {
        subNavItems.each((index, item) => {
            // Remove active classes
            $(item).removeClass('bg-green-100 text-gray-800');
            $(item).removeClass('hover:bg-green-200');

            // Reset to default state
            $(item).addClass('text-gray-700 hover:text-green-600');

            // Reset icon containers
            const iconContainer = $(item).find('div');
            if (iconContainer) {
                $(iconContainer).removeClass('bg-green-200');
                $(iconContainer).addClass('bg-gray-100');
            }

            // Reset icons
            const icon = $(item).find('i');
            if (icon) {
                $(icon).removeClass('text-green-600');
                $(icon).addClass('text-gray-600');
            }

            // Reset text weight
            const text = $(item).find('span');
            if (text) {
                $(text).removeClass('font-medium');
            }
        });
    }

    function addSubActiveClass(clickedItem) {
        // Add active classes (giống style trong hình ảnh)
        $(clickedItem).removeClass('text-gray-700 hover:text-green-600');
        $(clickedItem).addClass('bg-green-100 text-gray-800');
        $(clickedItem).addClass('hover:bg-green-200');

        // Update icon container
        const iconContainer = $(clickedItem).find('div');
        if (iconContainer) {
            $(iconContainer).removeClass('bg-gray-100');
            $(iconContainer).addClass('bg-green-200');
        }

        // Update icon
        const icon = $(clickedItem).find('i');
        if (icon) {
            $(icon).removeClass('text-gray-600');
            $(icon).addClass('text-green-600');
        }

        // Update text weight
        const text = $(clickedItem).find('span');
        if (text) {
            $(text).addClass('font-medium');
        }
    }

    subNavItems.each((index, item) => {
        $(item).on('click', function (e) {
            e.preventDefault();
            removeSubActiveClass();
            addSubActiveClass($(this));

            // Save active state to localStorage
            const activeNav = $(this).data('sub-nav');
            localStorage.setItem('activeSubNav', activeNav);
        });
    });

    // Restore active state from localStorage or set first item as default
    const savedActiveNav = localStorage.getItem('activeSubNav');
    if (savedActiveNav) {
        // Find and activate the saved item
        const savedItem = subNavItems.filter(`[data-sub-nav="${savedActiveNav}"]`);
        if (savedItem.length > 0) {
            addSubActiveClass(savedItem);
        } else {
            // If saved item not found, set first item as active
            if (subNavItems.length > 0) {
                addSubActiveClass(subNavItems.first());
            }
        }
    } else {
        // Set first item as active by default if no saved state
        if (subNavItems.length > 0) {
            addSubActiveClass(subNavItems.first());
        }
    }
});
