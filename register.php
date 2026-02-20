<?php
// statement LDAP
$ldap_server = "ldap://192.168.1.100";
$ldap_dn = "ou=users,dc=naweza,dc=ac,dc=tz"; 
$admin_user = "cn=administrator,dc=naweza,dc=ac,dc=tz"; 
$admin_pass = "Admin2025";

// connect na LDAP
$conn = ldap_connect($ldap_server);

if (!$conn) {
    die("fail to connect LDAP.");
}

ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_bind($conn, $admin_user, $admin_pass);

//form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Kuangalia kama jina la mtumiaji lipo tayari
$filter = "(uid=$username)";
$result = ldap_search($conn, $ldap_dn, $filter);
$entries = ldap_get_entries($conn, $result);

if ($entries['count'] > 0) {
    echo "Jina la mtumiaji lipo tayari.";
} else {
    // Kuunda mtumiaji mpya
    $new_user_dn = "uid=$username,$ldap_dn";
    $new_user_info = [
        'cn' => $username,
        'sn' => $username,
        'uid' => $username,
        'userPassword' => $password,
        'mail' => $email,
        'objectClass' => ['inetOrgPerson', 'posixAccount']
    ];

    // Kuongeza mtumiaji kwenye LDAP
    if (ldap_add($conn, $new_user_dn, $new_user_info)) {
        echo "Mtumiaji amesajiliwa kwa mafanikio.";
    } else {
        echo "Kuhifadhi mtumiaji kumeshindikana.";
    }
}

ldap_unbind($conn);
?>