<?php
  require("php/conn.php");
  $res = mysqli_fetch_assoc($conn->query("SELECT * FROM Companies LIMIT 1"));

  $is_anon = $res['is_anon'];
  $company_id = $res['id'];

  if(isset($_GET['is_anon']) && isset($_GET['company_id']))
  {
    $is_anon = base64_decode($_GET['is_anon']);
    $company_id = base64_decode($_GET['company_id']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестирование</title>
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <?php require("php/conn.php"); ?>
</head>
<body>
    <div class="container">
      <div class="helper w-75 border p-1 my-1 mx-auto bg-light rounded">
        <h2 class="text-center">Как заполнять тест:</h2>
        <p>
          Убедитесь, что вы понимаете вопрос.<br>
          Не задерживайтесь слишком долго на одном вопросе. Отвечайте на него сразу, как только поняли его, и переходите к следующему.<br>
          Для заполнения теста нужно ответить на вопрос: <b>Верно ли утверждение относительно вашей компании?</b><br>
          На каждое утверждение можно ответить:<br>
          <ul>
            <li>«Да» – означает «в основном, да» или твердое «да»,</li>
            <li>«Иногда» – означает «иногда бывает»,</li>
            <li>«Нет» – означает «нет» или «в основном, нет».</li>
          </ul>
          Чтобы получить результаты, вам нужно пройти весь тест целиком!<br>
          Отвечайте на вопросы, исходя из того, что происходит в вашей компании сейчас, а не происходило в прошлом.<br>
          Точность теста зависит от правдивости ваших ответов.<br>
          Готовы узнать себя настоящего?<br>
        </p>
      </div>
        <div class="test-button text-center">
            <button class="btn btn-primary btn-lg mt-5" data-bs-toggle="modal" data-bs-target="#exampleModal2">Пройти тест</button>
        </div>
        <!--Modal start-->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вариант теста</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-form text-center">
                    <?php if ($is_anon == 1): ?>
                      <button class="btn btn-primary my-1 anon_btn" data-bs-toggle="modal" data-bs-target="#exampleModal5">Пройти тест</button>
                    <?php else : ?>
                      <button class="btn btn-primary my-1 user_btn" data-bs-toggle="modal" data-bs-target="#exampleModal3">Пройти тест</button>
                    <?php endif; ?>
                    <button class="btn btn-primary my-1" data-bs-toggle="modal" data-bs-target="#exampleModal4">Для руководителя</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!--Modal end-->
        <!--Modal start-->
        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Данные пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="php/addPerson.php" method="POST">
                    <div class="mb-3">
                      <label for="exampleInputName" class="form-label">Имя</label>
                      <input type="text" name='first_name' class="form-control" id="exampleInputName" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Фамилия</label>
                      <input type="text" name='second_name' class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputName" class="form-label">Отчество</label>
                      <input type="text" name='last_name' class="form-control" id="exampleInputName" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                      <input type="hidden" name="company_id" class="company_id" value="<?php echo $company_id ?>">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputName" class="form-label">Должность</label>
                      <input type="text" name='post_position' class="form-control" id="exampleInputName" aria-describedby="nameHelp">
                    </div>
                    <div class="btn-submit text-center">
                        <button type="submit" class="btn btn-primary">Начать тест</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!--Modal end-->
        <!--Modal start-->
        <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Данные руководителя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="php/createSupervisor.php" method="POST">
                    <div class="mb-3">
                      <label for="exampleInputName" class="form-label">Имя</label>
                      <input type="text" name='first_name' class="form-control" id="exampleInputName" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Фамилия</label>
                      <input type="text" name='second_name' class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputName" class="form-label">Отчество</label>
                      <input type="text" name='last_name' class="form-control" id="exampleInputName" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                      <input type="hidden" name="company_id" class="company_id" value="<?php echo $company_id ?>">
                    </div>
                    <div class="btn-submit text-center">
                        <button type="submit" class="btn btn-primary">Начать тест</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!--Modal end-->
        <!--Modal start-->
        <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Анонимный тест</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="php/createAnonUser.php" method="POST">
                    <div class="mb-3">
                      <input type="hidden" name="company_id" class="company_id" value="<?php echo $company_id ?>">
                    </div>
                    <div class="btn-submit text-center">
                        <button type="submit" class="btn btn-primary">Начать тест</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!--Modal end-->
    </div>
    <script>
      var myModal = document.getElementById('myModal')
      var myInput = document.getElementById('myInput')

      myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
      })
    </script>
</body>
</html>