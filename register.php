<?php
include("config.php");

if (!ldap_bind($conn, $ldap_admin, $ldap_admin_password)) {
    die("Admin Bind Failed");
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];

$dn = "CN=$firstname $lastname,$ou_dn";

$user = [];
$user["cn"] = "$firstname $lastname";
$user["sn"] = $lastname;
$user["givenName"] = $firstname;
$user["objectClass"] = ["top","person","organizationalPerson","user"];
$user["userPrincipalName"] = "$username@company.local";
$user["sAMAccountName"] = $username;
$user["displayName"] = "$firstname $lastname";
$user["userAccountControl"] = 512;

if (ldap_add($conn, $dn, $user)) {

    $encoded_password = mb_convert_encoding("\"$password\"", "UTF-16LE");

    ldap_mod_replace($conn, $dn, [
        "unicodePwd" => $encoded_password
    ]);

    echo "User Registered Successfully ✅ <br>";
    echo "<a href='index.html'>Go Back</a>";

} else {
    echo "Registration Failed ❌";
}

ldap_close($conn);
?>