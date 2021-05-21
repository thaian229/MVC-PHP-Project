<?php
echo "HOME PAGE";
echo '<br>';
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
    echo '<a href="index.php?controller=auth&action=logout">LOGOUT</a><br>';
} else {
    echo '<a href="index.php?controller=auth&action=login">LOGIN</a><br>';
    echo '<a href="index.php?controller=auth&action=register">REGISTER</a><br>';
}
?>


<br>
<a href="<?php echo BASE_PATH . "index.php?controller=posts" ?>">VIDEOS LIST</a>
