<?php
include("config.php");

$username = $_POST['username'];
$password = $_POST['password'];

$user_dn = "$username@company.local";

if (@ldap_bind($conn, $user_dn, $password)) {

    $_SESSION['user'] = $username;
    header("Location: dashboard.php");

} else {
    echo "Login Failed ❌ <br>";
    echo "<a href='index.html'>Try Again</a>";
}

ldap_close($conn);
?>