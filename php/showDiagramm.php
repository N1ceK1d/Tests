<?php 
function getUserResult($user_id, $username){?>
  <div class='diagramm-item m-1 border w-50'>
    <?php
    require('conn.php');

    $sql = "SELECT SUM(Answers.points) as points, Criterions.name as criterion_name FROM UserAnswers
    INNER JOIN Users ON UserAnswers.user_id = Users.id
    INNER JOIN Answers ON UserAnswers.anser_id = Answers.id
    INNER JOIN Questions ON Answers.question_id = Questions.id
    INNER JOIN Criterions ON Questions.criterion_id = Criterions.id
    WHERE UserAnswers.user_id = $user_id
    GROUP BY Criterions.name";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
      $myArray[] = $row;
    }
    ?>
    <canvas id="myChart<?php echo $user_id ?>" style="max-width:500px;height:400px"></canvas>
    <script src="../js/diagramm.js"></script>
    <?php
      $company_name = "SELECT * FROM Users
      INNER JOIN Companies ON Users.company_id = Companies.id 
      WHERE Users.id = $user_id";

      $name = mysqli_fetch_assoc($conn->query($company_name));
    ?>
    <script>
      showDiagramm(<?php echo json_encode($myArray); ?>, <?php echo $user_id ?>, "<?php echo $username ?>", '<?php echo $name['name'] ?>');
    </script>
  </div>
<?php } ?>

<?php 
function getSupervisorResult($user_id, $username){?>
  <div class='diagramm-item m-1 border w-50'>
    <?php
    require('conn.php');

    $sql = "SELECT SUM(Answers.points) as points, Criterions.name as criterion_name FROM SupervisorAnswers
    INNER JOIN Supervisor ON SupervisorAnswers.supervisor_id = Supervisor.id
    INNER JOIN Answers ON SupervisorAnswers.anser_id = Answers.id
    INNER JOIN Questions ON Answers.question_id = Questions.id
    INNER JOIN Criterions ON Questions.criterion_id = Criterions.id
    WHERE SupervisorAnswers.supervisor_id = $user_id
    GROUP BY Criterions.name";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
      $myArray[] = $row;
    }
    ?>
    <canvas id="myChart<?php echo $user_id ?>" style="max-width:500px;height:400px"></canvas>
    <script src="../js/diagramm.js"></script>
    <?php
      $company_name = "SELECT * FROM Supervisor
      INNER JOIN Companies ON Supervisor.company_id = Companies.id 
      WHERE Supervisor.id = $user_id";

      $name = mysqli_fetch_assoc($conn->query($company_name));
    ?>
    <script>
      showDiagramm(<?php echo json_encode($myArray); ?>, <?php echo $user_id ?>, "<?php echo $username ?>", '<?php echo $name['name'] ?>');
    </script>
  </div>
<?php } ?>

<?php 
function getСomparisons($company_id){?>

  <div class='diagramm-item m-1 border w-50'>
    <?php
    require('conn.php');
    $sql = "SELECT ROUND(AVG(points), 0) * 10 as points, Criterions.name as criterion_name FROM UserAnswers
    INNER JOIN Users ON UserAnswers.user_id = Users.id
    INNER JOIN Answers ON UserAnswers.anser_id = Answers.id
    INNER JOIN Questions ON Answers.question_id = Questions.id
    INNER JOIN Criterions ON Questions.criterion_id = Criterions.id
    WHERE Users.company_id = $company_id
    GROUP BY Criterions.name";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
      $employees[] = $row;
    }

    $supervisors = "SELECT *, Supervisor.id as supervisor_id,
    CONCAT(second_name, ' ', first_name, ' ', last_name) AS fullname
    FROM Supervisor WHERE company_id = $company_id";

    foreach ($conn->query($supervisors) as $row) :?>
    <?php 
      $sql = "SELECT SUM(Answers.points) as points, Criterions.name as criterion_name FROM SupervisorAnswers
      INNER JOIN Supervisor ON SupervisorAnswers.supervisor_id = Supervisor.id
      INNER JOIN Answers ON SupervisorAnswers.anser_id = Answers.id
      INNER JOIN Questions ON Answers.question_id = Questions.id
      INNER JOIN Criterions ON Questions.criterion_id = Criterions.id
      WHERE Supervisor.company_id = $company_id AND Supervisor.id = ".$row['supervisor_id']."
      GROUP BY Criterions.name";
  
      $res = $conn->query($sql);
      
      while($row2 = $res->fetch_assoc()) {
        $managers[] = $row2;
      }
    ?>
    <canvas id="myChart<?php echo $row['supervisor_id'] ?>" style="max-width:500px;height:400px"></canvas>
    <script src="../js/diagramm.js"></script>
    <?php
      $company_name = "SELECT * FROM Supervisor
      INNER JOIN Companies ON Supervisor.company_id = Companies.id 
      WHERE Supervisor.id = ".$row['supervisor_id'];

      $name = mysqli_fetch_assoc($conn->query($company_name));
    ?>
    <script>
      showComparisonsDiagramm(<?php echo json_encode($employees); ?>, <?php echo json_encode($managers)?>, <?php echo $row['supervisor_id']; ?>, '<?php echo $row['fullname'] ?>', '<?php echo $name['name']; ?>');
    </script>
    <?php 
    $managers = array();
    endforeach; ?>
  </div>
<?php } ?>

<?php 
function getAverageResult($company_id, $company_name){?>
  <div class='diagramm-item m-1 border w-50'>
    <?php
    require('conn.php');

    $sql = "SELECT ROUND(AVG(points), 0) * 10 as points, Criterions.name as criterion_name
    FROM UserAnswers
    INNER JOIN Users ON UserAnswers.user_id = Users.id
    INNER JOIN Answers ON UserAnswers.anser_id = Answers.id
    INNER JOIN Questions ON Answers.question_id = Questions.id
    INNER JOIN Criterions ON Questions.criterion_id = Criterions.id
    WHERE Users.company_id = $company_id
    GROUP BY Criterions.name";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
      $myArray[] = $row;
    }
    ?>
    <canvas id="myChart<?php echo $company_id ?>" style="max-width:500px;height:400px"></canvas>
    <script src="../js/diagramm.js"></script>
    <script>
      showDiagramm(<?php echo json_encode($myArray); ?>, <?php echo $company_id ?>, '<?php echo $company_name; ?>', '<?php echo $company_name; ?>');
    </script>
  </div>
<?php } ?>