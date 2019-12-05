<?php
/**
 * Created by PhpStorm.
 * User: Анна
 * Date: 15.03.2017
 * Time: 13:11
 */
$host = 'localhost';
$db = 'db_diplom';
$user = 'root';
$password = '';
$mysqli = new mysqli($host, $user, $password,  $db);
//session_start();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Авторизация
    </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">


    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]--><!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

</head>
<body>
<!-- HTML-код модального окна -->
<div id="myModallogin" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header" style="background: rgb(243, 243, 243);">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Почему не получилось пройти авторизацию?</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <p>Возможно, у вас нажата клавиша CapsLock</p>
                <p>Проверьте раскладку клавиатуры: допускается использование только английского алфавита и цифр.</p>
                <p>Вы точно уже зарегистрировались?</p>
            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer" style="background: rgb(243, 243, 243);">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <!--                <button type="button" class="btn btn-primary">Сохранить изменения</button>-->
            </div>
        </div>
    </div>
</div>
<?php
session_start();
if(!empty($_POST))
{
    $connection_query = $mysqli->prepare("select * from student where username = ?");
    $connection_query->bind_param("s", $_POST['username']);
    $connection_query->execute();
    $user = $connection_query->get_result()->fetch_assoc();
    $v = password_verify($_POST["password"], $user["password"]);

    if ($v)
    {
                $_SESSION['username'] = $_POST["username"];
        header('location: /home.php?name='.$_SESSION['username']);
//        echo "если пользователь есть в базе, то переходим на домашнюю страницу  ";
//        echo $_SESSION['username'];
    }
    else
    {
        echo "<div class=\"page-header\" style=\"text-align: center\">
              <h1>Авторизация <small>
            <p>
                <span class=\"glyphicon glyphicon-check\"> позволяет зарегистрированным пользователям проходить тестирование</span>
            </p>
              </small></h1>
            </div>



                <form class=\"form-login\" method=\"post\" action=\"login2.php\">
                     <div class=\"input-group input-group-lg\">
                   <span class=\"input-group-addon\">

                   <span class=\"glyphicon glyphicon-pencil\"> </span>

               </span>
                 <input type=\"text\" class=\"form-control\" placeholder=\"Логин\" name=\"username\"
               data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
              </div>

                 <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                 <span class=\"glyphicon glyphicon-pencil\"> </span>
                 </span>
                 <input type=\"password\" class=\"form-control\" placeholder=\"Пароль\" name=\"password\"
               data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
                 </div>
                 <p> </p>

                 <button type=\"submit\" class=\"btn btn-default btn-lg\" style=\"margin-left: 45%;  margin-top: 20px\" >Войти</button>
                </form>";

        echo"<a href=\"#myModallogin\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\"  
        style=\"margin-left: 45%;  margin-top: 20px\" >Что то пошло не так...</a>";
    }
}
else
{
    if(isset($_SESSION['username']))
    {
                header('location: /home.php');
    }
    else
        include '/menu2.php';
    echo "
            <div class=\"page-header\" style=\"text-align: center\">
              <h1>Авторизация <small>
            <p>
                <span class=\"glyphicon glyphicon-check\"> позволяет зарегистрированным пользователям проходить тестирование</span>
            </p>
              </small></h1>
            </div>
                <form class=\"form-login\" method=\"post\" action=\"login2.php\">
                     <div class=\"input-group input-group-lg\">
                   <span class=\"input-group-addon\">

                   <span class=\"glyphicon glyphicon-pencil\"> </span>

               </span>
                 <input type=\"text\" class=\"form-control\" placeholder=\"Логин\" name=\"username\"
               data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
              </div>

                 <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                 <span class=\"glyphicon glyphicon-pencil\"> </span>
                 </span>
                 <input type=\"password\" class=\"form-control\" placeholder=\"Пароль\" name=\"password\"
               data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
                 </div>
                 <p> </p>

                 <button type=\"submit\" class=\"btn btn-default btn-lg\" style=\"margin-left: 45%;  margin-top: 20px\" >Войти</button>
                </form>
            ";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>