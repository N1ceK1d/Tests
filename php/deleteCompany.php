<?php 
require("conn.php");

$company_id = $_POST['company_id'];
$users = $conn->query("SELECT * FROM Users WHERE company_id = $company_id");
if($users->num_rows > 0)
{
    foreach ($users as $user) {
        $conn->query("DELETE FROM UserAnswers WHERE user_id = ".$user['id']);
        $conn->query("DELETE FROM Users WHERE id = ".$user['id']);
    }
}


$supervisors = $conn->query("SELECT * FROM Supervisor WHERE company_id = $company_id");
if($supervisors->num_rows > 0)
{
    foreach ($supervisors as $user) {
        $conn->query("DELETE FROM SupervisorAnswers WHERE supervisor_id = ".$user['id']);
        $conn->query("DELETE FROM Supervisor WHERE id = ".$user['id']);
    }
}


$sql = "DELETE FROM Companies WHERE id = $company_id";
if($conn->query($sql))
{
    header("Location: ../pages/_admin/companies.php");
}