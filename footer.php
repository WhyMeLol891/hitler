<footer>
    <p>&copy; 2024 My E-commerce Website. All Rights reserved.</p>

    <script>
        // JavaScript for dropdown menu
        const userMenu = document.querySelector('.nav-links li:last-child');
        const dropdown = document.querySelector('.submenu');

        userMenu.addEventListener('click',()=> {
            dropdown.classList.toggle('show');
        });

        window.addEventListener('click',(e) => {
            if (!userMenu.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

</footer>

</body>
</html>