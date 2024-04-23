<?php
require('conn.php');

$company_id = $_POST['company_id'];

$sql = "INSERT INTO Users (first_name, second_name, last_name, post_position, is_anon, company_id)
VALUES ('Анонимный', '', '', '', 1, $company_id)";

if($conn->query($sql))
{
    session_start();
    $_SESSION['user_id'] = $conn->insert_id;
    header("Location: ../pages/test.php"); 
} else 
{
    echo $conn->error;
}
?>