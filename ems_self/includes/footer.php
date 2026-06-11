<footer id="main-footer" class="text-center py-4 text-muted w-100" style="font-size: 0.85rem; border-top: 1px solid #f1f5f9; background-color: var(--body-bg);">
    Employee Management System &copy; 2026
</footer>
<script>
    (function() {
        var mainContent = document.querySelector('.flex-grow-1');
        var footer = document.getElementById('main-footer');
        if(mainContent && footer) {
            mainContent.classList.add('d-flex', 'flex-column');
            footer.classList.add('mt-auto');
            mainContent.appendChild(footer);
        }
    })();
</script>
