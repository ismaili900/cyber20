<?php
$conn = new mysqli("localhost", "root", "@Password", "musiba");

if ($conn->connect_error) {
    die("Connection failed");
}
?>
