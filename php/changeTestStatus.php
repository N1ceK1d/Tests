<?php
require("conn.php");
$company_id = $_POST['company_id'];
$anon_value = $_POST['anon_value'];

$conn->query("UPDATE Companies SET is_anon = $anon_value WHERE id = $company_id");

header("Location: ../pages/_admin/companies.php");