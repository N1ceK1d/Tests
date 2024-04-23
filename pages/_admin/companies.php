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
    <title>Компании</title>
    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="../../js/diagramm.js"></script>
    <link rel="stylesheet" href="../../bootstrap/bootstrap-icons/font/bootstrap-icons.min.css">
    <script src="../../js/jquery-3.7.1.min.js"></script>
    <script src="../../js/main.js"></script>
</head>
<body>
    <div class="container p-1">
        <h1>Предприятия</h1>
        <?php require("../../php/admin_header.php"); ?>
        <form class='border w-25 p-2 m-auto text-center' action="../../php/addCompany.php" method="post">
            <input class='form-control' type="text" name="name" id="" required placeholder='Название компании'>
            <input class="btn btn-primary my-1" type="submit" value="Добавить">
        </form>
        <?php
            $res = $conn->query("SELECT * FROM Companies;");    
        ?>
        <div class="companies">
            <?php foreach ($res as $row):?>
                <div class="company-item cart border w-75 p-1 my-1 bg-light">
                    <h2 class="name"><?php echo $row['name']; ?></h2>
                    <div class="company_settings">
                        <label><?php echo $row['is_anon'] == 1 ? 'Анонимно' : 'Не анонимно' ?></label>
                        <i role="button" 
                        class="bi bi-pencil-fill text-primary button"
                        data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo $row['id'];?>"></i>
                        <i role="button" class="bi bi-trash-fill text-danger"
                        data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="<?php echo $row['id'];?>"></i>
                    </div>
                    <button type='button' class='btn btn-primary my-1 copied_text_btn liveToastBtn'>Скопировать ссылку</button>
                    <?php $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'?company_id='.urlencode(base64_encode($row['id'])).'&is_anon='.urlencode(base64_encode($row['is_anon'])); ?>
                    <input type="hidden" class='copied_text' value='<?php echo $url ?>'>
                </div>
            <?php endforeach ?>
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
                    <form method="POST" action="../../php/changeTestStatus.php">
                        <input type="hidden" name="company_id" value="" class='company_id'>
                        <div class="mb-3">
                            <select name="anon_value" class="form-select">
                                <option value="0">Сделать открытым</option>
                                <option value="1">Сделать анонимным</option>
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
    <!--Modal Start-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Удаление компании</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../php/deleteCompany.php">
                        <input type="hidden" name="company_id" value="" class='company_id'>
                        <div class="mb-3">
                            <p>Вы уверены, что хотите удалить эту компанию?</p>
                        </div>
                        <button type="submit" class="btn btn-danger">Удалить</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal End-->
    <!-- Bootstrap Toast Notification -->
    <!-- <div class="toast bg-primary text-white top-0 start-50 translate-middle-x position-absolute" id="copiedToast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            Ссылка скопирована в буфер обмена
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div> -->
    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-whatever');

            var modalBodyInput = exampleModal.querySelector('.modal-body #recipient-name ')
            console.log(recipient);
            exampleModal.querySelector('.modal-body .company_id').value = recipient;
        });

        var exampleModal = document.getElementById('exampleModal2')
        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-whatever');

            var modalBodyInput = exampleModal.querySelector('.modal-body #recipient-name ')
            console.log(recipient);
            exampleModal.querySelector('.modal-body .company_id').value = recipient;
        })

        $('.copied_text_btn').click(function() {
            // Находим родительский элемент кнопки, чтобы добавить поле с URL в него
            var parent = $(this).closest('.company-item');

            // Проверяем, существует ли уже поле с URL в родительском элементе
            var urlField = parent.find('.copied_url');
            if (urlField.length === 0) {
                // Если поле не существует, создаем новое поле с URL
                urlField = $('<input>');
                urlField.attr('type', 'text');
                urlField.attr('readonly', true);
                urlField.addClass('form-control mt-2 copied_url');
                parent.append(urlField);
            }

            // Находим скрытое поле с URL в родительском элементе
            var copiedText = parent.find('.copied_text');

            // Заполняем поле с URL значением из скрытого поля
            urlField.val(copiedText.val());

            // Показываем поле с URL
            urlField.show();
        });
    </script>

</body>
</html>