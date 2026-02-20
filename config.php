<?php
session_start();

$ldap_server = "ldap://192.168.1.10";
$ldap_admin = "admin@company.local";
$ldap_admin_password = "AdminPassword";

$base_dn = "DC=company,DC=local";
$ou_dn = "OU=Students,DC=company,DC=local";

$conn = ldap_connect($ldap_server);
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

if (!$conn) {
    die("LDAP Connection Failed");
}
?>