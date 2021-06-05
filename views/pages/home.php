<link rel="stylesheet" href="views/pages/home.css">

<?php
echo "HOME PAGE<br>";
echo '<br>';
if (isset($_SESSION['session_username'])) {
    echo $_SESSION['session_username'] . "<br>";

    echo '<a href="index.php?controller=users&action=changeProfile">Change Profile</a><br>';
    echo '<a href="index.php?controller=auth&action=logout">LOGOUT</a><br>';

} else {
    echo '<a href="index.php?controller=auth&action=login">LOGIN</a><br>';
    echo '<a href="index.php?controller=auth&action=register">REGISTER</a><br>';
}
?>


<br>
<a href="index.php?controller=posts">VIDEOS LIST</a>
