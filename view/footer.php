<footer>
    <p class="copyright">
        
        &copy; <?php echo date("Y"); ?>, Gabriel Skramstad
    </p>
    <p>
        <?php
        

        if (isset($_SESSION['customer'])) {
            $user = $_SESSION['customer'];
            echo "welcome ".$user -> getuserName();
        }
        ?>
    </p>
</footer>
</main>
</body>
</html>