<?php
  require("../php/conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестирование</title>
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <?php require("../php/conn.php"); ?>
</head>
<body>
    <div class="container">
        <?php
            $supervisors = "SELECT * FROM Supervisor WHERE company_id = 2";
            $managers_list = [];
            if($conn->query($supervisors))
            {
                foreach ($conn->query($supervisors) as $row) {
                    $sql = "SELECT SUM(Answers.points) as points, Criterions.name as criterion_name FROM SupervisorAnswers
                    INNER JOIN Supervisor ON SupervisorAnswers.supervisor_id = Supervisor.id
                    INNER JOIN Answers ON SupervisorAnswers.anser_id = Answers.id
                    INNER JOIN Questions ON Answers.question_id = Questions.id
                    INNER JOIN Criterions ON Questions.criterion_id = Criterions.id
                    WHERE Supervisor.company_id = 2 AND Supervisor.id = ".$row['id']."
                    GROUP BY Criterions.name";
                    
                    $res = $conn->query($sql);
                    
                    while($row2 = $res->fetch_assoc()) {
                        // var_dump($row2);
                        $managers[] = $row2;
                        
                    }
                    $managers_list[] = $managers;
                    $managers = array();
                }
                
            }
            
            
        ?>
        <select name="" id="select">
        </select>
        <div class="diagramm-item">
            <canvas id="myChart1" style="max-width:500px"></canvas>
        </div>
        
        <script src="../js/diagramm.js"></script>
        <script>
            $(document).ready(() => {
                $.map(<?php echo json_encode($managers_list); ?>, (item) => {
                    $('#select').append(`<option value='${JSON.stringify(item)}'>DDDD</oprion>`)
                    console.log(item);
                })
                showDiagramm(JSON.parse($('#select').val()), 1, "TEST")
                $('#select').on('change', (event) => {
                    // console.log(JSON.parse($(event.target).val()));
                    showDiagramm(JSON.parse($(event.target).val()), 1, "TEST")
                })
                // console.log(<?php //echo json_encode($managers_list); ?>);
            })
            
        </script>
    </div>
</body>
</html>