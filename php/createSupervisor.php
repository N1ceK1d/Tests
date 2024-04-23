<?php
require('conn.php');

$first_name = $_POST['first_name'];
$second_name = $_POST['second_name'];
$last_name = $_POST['last_name'];
$company_id = $_POST['company_id'];

$sql = "INSERT INTO Supervisor (first_name, second_name, last_name, company_id)
VALUES ('$first_name', '$second_name', '$last_name', $company_id)";

if($conn->query($sql))
{
    session_start();
    $_SESSION['supervisor_id'] = $conn->insert_id;
    header("Location: ../pages/director_test.php"); 
}
?>