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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Руководители</title>
    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="../../js/diagramm.js"></script>
</head>
<body>
    <div class="container p-1">
        <h1>Руководители</h1>
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
            <input type="submit" value="Найти" class="btn btn-primary my-1">
        </form>
        <div class="diagramms">
            <?php 
                if($company_id > 0)
                {
                    $sql = "SELECT * FROM Supervisor WHERE company_id = $company_id;";
                } else 
                {
                    $sql = "SELECT * FROM Supervisor;";
                }
                foreach ($conn->query($sql) as $row)
                {
                    getSupervisorResult($row['id'], $row['first_name']." ".$row['last_name']);
                }
            ?>
        </div>
    </div>
</body>
</html>