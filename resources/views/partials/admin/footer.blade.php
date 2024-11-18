</section>
<footer class="footer">
    <p>&copy; 2024 FATIMAH BOUQUET. All Rights Reserved.</p>
    <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Contact Us</a>
    </div>
</footer>
<script>
    const hamburgerOpen = document.querySelector('.hamburger .buka');
    const hamburgerClose = document.querySelector('.hamburger .tutup');
    const sidebar = document.querySelector('.sidebar');

    hamburgerOpen.addEventListener('click', () => {
        sidebar.classList.add('active');
        hamburgerOpen.style.display = 'none';
        hamburgerClose.style.display = 'block';
    });

    hamburgerClose.addEventListener('click', () => {
        sidebar.classList.remove('active');
        hamburgerOpen.style.display = 'block';
        hamburgerClose.style.display = 'none';
    });
</script>
</body>

</html>
