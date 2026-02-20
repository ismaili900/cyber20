<?php

$ldap_server = "ldaps://192.168.1.10"; // IP ya Windows Server
$ldap_admin = "admin@company.local";
$ldap_password = "AdminPassword";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];

$dn = "CN=$firstname $lastname,OU=Students,DC=company,DC=local";

$conn = ldap_connect($ldap_server);
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

if (!ldap_bind($conn, $ldap_admin, $ldap_password)) {
    die("LDAP Bind Failed");
}

$user = [];
$user["cn"] = "$firstname $lastname";
$user["sn"] = $lastname;
$user["givenName"] = $firstname;
$user["objectClass"] = ["top", "person", "organizationalPerson", "user"];
$user["userPrincipalName"] = "$username@company.local";
$user["sAMAccountName"] = $username;
$user["displayName"] = "$firstname $lastname";
$user["userAccountControl"] = 512; // enable account

if (ldap_add($conn, $dn, $user)) {

    // Set Password (MUST BE UTF-16LE)
    $encoded_password = mb_convert_encoding("\"$password\"", "UTF-16LE");

    ldap_mod_replace($conn, $dn, [
        "unicodePwd" => $encoded_password
    ]);

    echo "User Created Successfully in Active Directory ✅";

} else {
    echo "User Creation Failed ❌";
}

ldap_close($conn);

?>