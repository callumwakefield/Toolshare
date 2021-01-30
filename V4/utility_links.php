<!doctype html>
<html>
        <head>
        <link rel="stylesheet" href="style.css">
        </head>
</html>

<?php 
    if(isset($_SESSION['username'])) : ?>
        <div class="dropdown">
            <button class="dropbtn">Utilitys</button>
            <div class="drop_content">
                <a href="browse.php">Brows tools</a>
                <a href="register_tool.php">register tools</a>
                <a href="users_tools.php">My tools</a>
            </div>
        </div>
        

<?php endif; ?>

