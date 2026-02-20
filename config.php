<?php
session_start();

$ldap_server = "ldap://192.168.1.100";
$ldap_admin = "administrator@naweza.ac.tz";
$ldap_admin_password = "Admin2025";

$base_dn = "DC=naweza,DC=ac,DC=tz";
$ou_dn = "OU=Students,DC=naweza,DC=ac,DC=tz";

$conn = ldap_connect($ldap_server);
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

if (!$conn) {
    die("LDAP Connection Failed");
}
?>