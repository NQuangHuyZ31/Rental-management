/**
 * Fix Double Scrollbar Issue
 * Ensures only one scrollbar is visible on customer pages
 */

document.addEventListener('DOMContentLoaded', function () {
    // Function to fix scrollbar issues
    function fixScrollbarIssues() {
        // Remove any duplicate scrollbars
        const body = document.body;
        const html = document.documentElement;

        // Ensure body and html don't have overflow
        body.style.overflow = 'hidden';
        html.style.overflow = 'hidden';

        // Find main content area
        const mainContent = document.querySelector('.content-area');
        if (mainContent) {
            // Ensure main content is the only scrollable element
            mainContent.style.overflowY = 'auto';
            mainContent.style.overflowX = 'hidden';
            mainContent.style.height = '100%';
        }

        // Fix sidebar scrollbar
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.style.overflowY = 'auto';
            sidebar.style.overflowX = 'hidden';
        }

        // Remove any horizontal scroll
        const allElements = document.querySelectorAll('*');
        allElements.forEach((element) => {
            if (element.scrollWidth > element.clientWidth) {
                element.style.overflowX = 'hidden';
            }
        });
    }

    // Fix scrollbar issues on load
    fixScrollbarIssues();

    // Fix scrollbar issues on window resize
    window.addEventListener('resize', function () {
        setTimeout(fixScrollbarIssues, 100);
    });

    // Fix scrollbar issues when content changes
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                setTimeout(fixScrollbarIssues, 100);
            }
        });
    });

    // Start observing
    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });

    // Fix scrollbar issues on navigation
    document.addEventListener('click', function (e) {
        if (e.target.tagName === 'A' && e.target.href) {
            setTimeout(fixScrollbarIssues, 500);
        }
    });

    // Prevent horizontal scroll on touch devices
    document.addEventListener(
        'touchmove',
        function (e) {
            const target = e.target;
            const scrollableParent = target.closest('.content-area');

            if (!scrollableParent) {
                e.preventDefault();
            }
        },
        { passive: false }
    );

    // Fix for iOS Safari
    if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        document.addEventListener('touchstart', function () {}, { passive: true });
        document.addEventListener('touchmove', function () {}, { passive: true });
    }
});

// Utility function to check for scrollbar issues
function checkScrollbarIssues() {
    const body = document.body;
    const html = document.documentElement;

    const bodyHasScroll = body.scrollHeight > body.clientHeight;
    const htmlHasScroll = html.scrollHeight > html.clientHeight;

    if (bodyHasScroll || htmlHasScroll) {
        console.warn('Scrollbar issue detected:', {
            bodyScroll: bodyHasScroll,
            htmlScroll: htmlHasScroll,
            bodyHeight: body.scrollHeight,
            bodyClientHeight: body.clientHeight,
            htmlHeight: html.scrollHeight,
            htmlClientHeight: html.clientHeight,
        });
        return true;
    }

    return false;
}

// Export for debugging
window.checkScrollbarIssues = checkScrollbarIssues;
