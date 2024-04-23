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
    <title>Администратор</title>
    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="../../js/diagramm.js"></script>
    <link rel="stylesheet" href="../../bootstrap/bootstrap-icons/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container p-1">
        <h1>Все сотрудники</h1>
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
        <div class="employees">
        <?php
            $sql = "SELECT *, Users.id as user_id, CONCAT(second_name, ' ',first_name , ' ', last_name) AS fullname FROM Users  
            INNER JOIN Companies ON Users.company_id = Companies.id
            WHERE Users.is_anon = 0";
            if($company_id > 0)
            {
                $sql .= " AND company_id = $company_id";
            }

            foreach ($conn->query($sql) as $row): ?>
                <div class="employee-item border rounded bg-light p-1 m-1">
                    <h2><?php echo $row["fullname"]; ?></h2>
                    <div class="company_settings">
                        <label><?php echo $row["name"]; ?></label>
                        <i role="button" 
                        class="bi bi-pencil-fill text-primary button"
                        data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo $row['fullname'].",".$row['user_id']; ?>"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--Modal Start-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Изменить компанию</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="../../php/changeEmployee.php">
                <input type="hidden" name="user_id" value="" class='user_id'>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Сотрудник:</label>
                    <input type="text" class="form-control" id="recipient-name" readonly>
                </div>
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Компания</label>
                    <select name="company_id" class="form-select">
                        <?php
                        $companies = $conn->query("SELECT * FROM Companies;");
                        foreach ($companies as $row):?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Изменить</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--Modal End-->
    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function (event) {
        // Кнопка, запускающая модальное окно
            var button = event.relatedTarget
            // Извлечь информацию из атрибутов data-bs- *
            var recipient = button.getAttribute('data-bs-whatever');
            var user_id = button.getAttribute('data-bs-whatever').split(',')[1];
            var fullname = button.getAttribute('data-bs-whatever').split(',')[0];
            console.log(user_id);
            var modalBodyInput = exampleModal.querySelector('.modal-body #recipient-name ')

            modalBodyInput.value = fullname;
            exampleModal.querySelector('.modal-body .user_id').value = user_id;
        })
    </script>
</body>
</html>