import './bootstrap';
import PerfectScrollbar from 'perfect-scrollbar';
import 'perfect-scrollbar/css/perfect-scrollbar.css';

// Gắn Perfect Scrollbar vào container
document.addEventListener('DOMContentLoaded', () => {
    createScroll('.scroll-container');
    createScroll('.category-scroll-container');
    createScroll('.brand-scroll-container');
    createScroll('.attribute-scroll-container');
    createScroll('.variation-scroll-container');
});
function createScroll(class_scroll) {
    const container = document.querySelector(class_scroll);
    if (container) {
        return new PerfectScrollbar(container, {
            suppressScrollX: true,
        });
    }
}