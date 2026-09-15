<script>
(function () {
    try {
        var theme = localStorage.getItem('pm-theme');
        if (theme === 'dark' || theme === 'light') {
            document.documentElement.setAttribute('data-theme', theme);
        }
    } catch (e) {}
})();
</script>
