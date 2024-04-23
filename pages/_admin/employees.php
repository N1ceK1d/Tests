<?php
    session_start();
    if(!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
    }
    require("../../php/conn.php");
    require("../../php/showDiagramm.php");
    $company_id = 0;
    if(isset($_GET['company_id']))
    {
        $company_id = $_GET['company_id'];
    }
    $user_type = 0;
    if(isset($_GET['user_type']))
    {
        $user_type = $_GET['user_type'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Работники</title>
    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="../../js/diagramm.js"></script>
</head>
<body>
    <div class="container p-1">
        <h1>Сотрудники</h1>
        <?php require("../../php/admin_header.php"); ?>
        <form class="search form border w-25 p-2 m-auto text-center" action="" method="GET">
            <select name="company_id" class="form-select form-select-sm my-1 w-100" aria-label="Default select example">
                <option value="0" selected>Все компании</option>
                <?php
                    $companies = $conn->query("SELECT * FROM Companies;");
                    foreach ($companies as $row):?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach ?>
            </select>
            <div class="types text-start">
                <div class="answer-item text-left">
                    <input class="form-check-input radio_inp" type="radio" name='user_type' value="0"/>
                    <label class='large'>Все</label>
                </div>
                <div class="answer-item">
                    <input class="form-check-input radio_inp" type="radio" name='user_type' value="1"/>
                    <label class='large'>Анонимные</label>
                </div>
                <div class="answer-item">
                    <input class="form-check-input radio_inp" type="radio" name='user_type' value="2"/>
                    <label class='large'>Не анонимные</label>
                </div>
            </div>
            
            <input type="submit" value="Найти" class="btn btn-primary my-1">
        </form>
        <div class="diagramms">
            <?php 
                
                if($company_id > 0)
                {
                    $sql = "SELECT * FROM Users WHERE company_id = $company_id";
                    if($user_type > 0)
                    {
                        if($user_type == 1) 
                        {
                            $sql .= " AND is_anon = 1";
                        }
                        if($user_type == 2) 
                        {
                            $sql .= " AND is_anon = 0";
                        }
                    } 
                } else 
                {
                    $sql = "SELECT * FROM Users";
                    if($user_type > 0)
                    {
                        if($user_type == 1) 
                        {
                            $sql .= " WHERE is_anon = 1";
                        }
                        if($user_type == 2) 
                        {
                            $sql .= " WHERE is_anon = 0";
                        }
                    } 
                }
                foreach ($conn->query($sql) as $row)
                {
                    getUserResult($row['id'], $row['first_name']." ".$row['last_name']);
                }
            ?>
        </div>
    </div>
</body>
</html>