<?php
session_start();

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;

    $pass = $_POST['pass'];
    $_SESSION['pass'] = $pass;

    header('Location: calculate.php');
    exit();
}
?>
