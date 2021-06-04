<header>
    <div class="topnav">
        <a class="home" href="index.php?controller=posts">Home</a>
        <?php
        if(isset($_SESSION['session_user_id'])) {
            echo '
                <a class="logout" href="index.php?controller=auth&action=logout">Logout</a>
                <a class="profile" href="index.php?controller=users">Profile</a>
            ';
        }
        else {
            echo '
                <a class="login" href="index.php?controller=auth&action=login">Login</a>
                <a class="register" href="index.php?controller=auth&action=register"">Register</a>
            ';
        }
        ?>

        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search..." name="search">
                <button class="fa fa-search" type="submit"></i></button>
            </form>
        </div>
    </div>
</header>