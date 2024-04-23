<?php
require('conn.php');

$first_name = $_POST['first_name'];
$second_name = $_POST['second_name'];
$last_name = $_POST['last_name'];
$post_position = $_POST['post_position'];
$company_id = $_POST['company_id'];

$sql = "INSERT INTO Users (first_name, second_name, last_name, post_position, is_anon, company_id)
VALUES ('$first_name', '$second_name', '$last_name', '$post_position', 0, $company_id)";

if($conn->query($sql))
{
    session_start();
    $_SESSION['user_id'] = $conn->insert_id;
    header("Location: ../pages/test.php"); 
}
?>