<?php
session_start();
include 'config.php'; // Kuunganisha fail la config.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $ou = isset($_POST['ou']) ? $_POST['ou'] : '';

    // Unganisha unapomaliza kudurusu LDAP
    if (!ldap_bind($conn, $ldap_admin, $ldap_admin_password)) {
        die("Kosa: Hujaweza kuungana na seva ya LDAP. Taarifa za kuingia si sahihi.");
    }

    // Fanya utafutaji
    $search_base = "OU={$ou},{$base_dn}"; // Jina la utafutaji
    $search_filter = "(uid={$username})";

    $search_result = ldap_search($conn, $search_base, $search_filter);
    if ($search_result === false) {
        die("Kosa: Utafutaji ulikwama.");
    }

    $entries = ldap_get_entries($conn, $search_result);
    if ($entries['count'] > 0) {
        die("Kosa: Jina la mtumiaji tayari lipo.");
    }

    // Andika mtumiaji mpya
    $dn = "uid={$username},OU={$ou},{$base_dn}"; // Ujumbe wa mtumiaji wa LDAP
    $new_user = [
        "cn" => $username,
        "sn" => $username,
        "uid" => $username,
        "userpassword" => $password,
        "objectClass" => ["top", "person", "organizationalPerson", "inetOrgPerson"]
    ];

    if (!ldap_add($conn, $dn, $new_user)) {
        die("Kosa: Hujaweza kuongeza mtumiaji.");
    }

    echo "Usajili umefanikiwa!";
    ldap_close($conn);
}
?>