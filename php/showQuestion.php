<?php 
    require("conn.php");
    session_start();
    $quest_id = 1;
    if(isset($_GET['quest_id']))
    {
        $quest_id = $_GET['quest_id'];
    }

    $sql = "SELECT * FROM Questions WHERE id = $quest_id";
    $res = mysqli_fetch_assoc($conn->query($sql));
    $sql2 = "SELECT * FROM Questions ORDER BY id DESC LIMIT 1";
    $last_query_id = mysqli_fetch_assoc($conn->query($sql2))['id'];
    $quest_id += 1;

    $answers_sql = "SELECT *, Answers.id as answer_id FROM Answers WHERE question_id = ".($quest_id-1);
    $answers = $conn->query($answers_sql);

    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url = $url[0];
?>

<form class="question-item col-lg-5  mt-2 mx-auto border rounded shadow-sm" method="GET" action="../php/saveAnswer.php">
    <div class='header bg-primary text-light p-1'>
        <h4><?php echo $res['question_text'];?></h4>
    </div>
    <p class="text-center text-muted">Вопрос: <?php echo $last_query_id."/".($quest_id-1); ?></p>
    <div class="answers p-1">
        <?php foreach ($answers as $row) :?>  
            <div class="answer-item">
                <input class="form-check-input radio_inp" type="radio" name='answer' value="<?php echo $row['answer_id']; ?>"/>
                <label class='lead'><?php echo $row['anser_text']; ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="answer_id" class='answer_id'>
    <input type="hidden" name="quest_id" value="<?php echo $quest_id ?>">
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
    <?php if(($quest_id-1) < $last_query_id): ?>
            <div class="btn-submit p-1">
                <?php if($quest_id > 2): ?>
                    <a class="btn btn-primary btn-lg next_btn" href="<?php echo $url.'?quest_id='.($quest_id -= 2);?>">Назад</a>
                <?php endif; ?>
                    <input class="btn btn-primary btn-lg next_btn" type="submit" value="Далее" disabled='true'>
            </div>
    <?php else:?>
        <div class="btn-submit text-center p-1">
            <input class="btn btn-success btn-lg next_btn" type="button" value="Закончить тест" data-bs-toggle="modal" data-bs-target="#exampleModal" disabled='true'>
        </div>
    <?php endif; ?>
</form>

<!--Modal start-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-form text-center">
            <form action="../pages/endTest.php" method="POST">
                <p>Спасибо, что прошли наш тест!</p>
                <button class="btn btn-success">Закончить</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="../js/main.js"></script>
<!--Modal end-->