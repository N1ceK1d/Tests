<?php
require('conn.php');
session_start();
$answer_id = $_GET['answer_id'];
if(isset($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];
    
} else 
{
   $user_id = $_GET['user_id']; 
}

$quest_id = $_GET['quest_id'];

$sql = "SELECT UserAnswers.id as user_answer FROM UserAnswers
INNER JOIN Answers ON UserAnswers.anser_id = Answers.id
INNER JOIN Questions ON Answers.question_id = Questions.id
WHERE UserAnswers.user_id = $user_id AND Questions.id = ".($quest_id-1)." LIMIT 1;";

$res = $conn->query($sql);

if($res->num_rows > 0)
{
    $user_answer_id = mysqli_fetch_assoc($res);
    $sql = "UPDATE UserAnswers SET anser_id = $answer_id WHERE user_id = $user_id AND id = ".$user_answer_id['user_answer'];
} else 
{
    $sql = "INSERT INTO UserAnswers (user_id, anser_id) VALUES ($user_id, $answer_id);";
}

if($conn->query($sql))
{
    header("Location: ../pages/test.php?quest_id=$quest_id");
} else 
{
    echo $conn->error;
}