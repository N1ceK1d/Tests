<?php
require("conn.php");

$user_id = $_POST['user_id'];
$company_id = $_POST['company_id'];

$conn->query("UPDATE Users SET company_id = $company_id WHERE id = $user_id");

header("Location: ../pages/_admin/all_employees.php");