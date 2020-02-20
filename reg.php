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
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header" style="background: rgb(243, 243, 243);">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Почему не получилось зарегистрироваться?</h4>
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
if ( !empty($_POST) )
{
    $username = $_POST["username"];
    $password = password_hash($_POST["password"],PASSWORD_BCRYPT);
    $email = $_POST["email"];
    $prava = 1;
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];

    $articles = $mysqli->query("select  username from student where username='$username' or email='$email'");

    if ($articles->num_rows == 2) {
        echo "<div class=\"row\">
                <div class=\"col-md-4\"></div>
                <div class=\"col-md-4\"><a href=\"#myModal2\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\"  
                 style=\"margin-left: 45%;  margin-top: 20px\" >Что то пошло не так...</a></div>
                <div class=\"col-md-4\"></div>
            </div>";
    }
    $articles = $mysqli->query("select  username from student where username='$username' or email='$email'");
    if ($articles->num_rows == 0) {
        if ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $last_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $first_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $second_name))
        ) {
            $connect = $mysqli->prepare("insert into student VALUES (DEFAULT, ?,?,?,?,?,?,1)");
            $connect->bind_param("ssssss", $first_name, $second_name, $last_name, $username, $password, $email);

            if ( !($connect->execute()) ) {
                echo $mysqli->error;
            } else {
                $_SESSION["username"] = $username;
                header('location: /home.php?name=' . $_SESSION['username']);
            }
        } elseif ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $last_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $first_name))
        ) {
            $connect = $mysqli->prepare("insert into student VALUES (DEFAULT, ?,NULL ,?,?,?,?,1)");
            $connect->bind_param("sssss", $first_name, $last_name, $username, $password, $email);

            if (!($connect->execute())) {
                echo $mysqli->error;
            } else {
                $_SESSION["username"] = $username;
                header('location: /home.php?name=' . $_SESSION['username']);
            }
        } elseif
        ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email))
        )
        {
            $connect = $mysqli->prepare("insert into student VALUES (DEFAULT, NULL ,NULL ,NULL ,?,?,?,1)");
            $connect->bind_param("sss", $username, $password, $email);

            if ( !($connect->execute()) ) {
                echo $mysqli->error;
            } else {
                $_SESSION["username"] = $username;
                header('location: /home.php?name=' . $_SESSION['username']);
            }
        }
        else {
            include '/menu2.php';
            echo "   <div class=\"page-header\" style=\"text-align: center\">
            <h1>Регистрация
                <small>
                    <p>
                        <span class=\"glyphicon glyphicon-pencil\"> заполнение обязательно</span>
                    </p>
                    <p>
                        <span class=\"glyphicon glyphicon-question-sign\"> заполнение по желанию</span>
                    </p>
                </small>
            </h1>
        </div>
        <form class=\"form-register\" method=\"post\" action=\"reg.php\">
            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Логин\" name=\"username\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"password\" class=\"form-control\" placeholder=\"Пароль\" name=\"password\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"E-mail\" name=\"email\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"pochta123@mail.ru\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Фамилия\" name=\"last_name\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы русского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Имя\" name=\"first_name\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы руского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Отчество\" name=\"second_name\"
                        data-toggle=\"tooltip\" data-placement=\"right\" title=\"Тoлько буквы русского алфавита\">
            </div>
            <p></p>
            <div class=\"row\">
                <div class=\"col-md-4\"></div>
                <div class=\"col-md-4\"><button type=\"submit\" class=\"btn btn-default btn-lg\" style=\"align-content: center\"  >Регистрация</button></div>
                <div class=\"col-md-4\"></div>
            </div>
        </form>";

            echo"<a href=\"#myModal\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\"  
        style=\"margin-left: 45%;  margin-top: 20px\" >Что то пошло не так...</a>";
        }
    }
    else {
         include '/menu2.php';
         echo "  
  
   <div class=\"page-header\" style=\"text-align: center\">
            <h1>Регистрация
                <small>
                    <p>
                        <span class=\"glyphicon glyphicon-pencil\"> заполнение обязательно</span>
                    </p>
                    <p>
                        <span class=\"glyphicon glyphicon-question-sign\"> заполнение по желанию</span>
                    </p>
                </small>
            </h1>
        </div>
        <form class=\"form-register\" method=\"post\" action=\"reg.php\">
            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Логин\" name=\"username\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"password\" class=\"form-control\" placeholder=\"Пароль\" name=\"password\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"E-mail\" name=\"email\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"pochta123@mail.ru\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Фамилия\" name=\"last_name\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы русского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Имя\" name=\"first_name\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы руского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Отчество\" name=\"second_name\"
                        data-toggle=\"tooltip\" data-placement=\"right\" title=\"Тoлько буквы русского алфавита\">
            </div>
            <p></p>
            <div class=\"row\">
                <div class=\"col-md-4\"></div>
                <div class=\"col-md-4\"><button type=\"submit\" class=\"btn btn-default btn-lg\" style=\"align-content: center\"  >Регистрация</button></div>
                <div class=\"col-md-4\"></div>
            </div>
        </form>";

        echo"<a href=\"#myModallogin\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\"  
        style=\"margin-left: 45%;  margin-top: 20px\" >Что то пошло не так...</a>";
    }
} else {
    if ( isset($_SESSION['username']) ) {
        header('location: /home.php');
    } else
        include '/menu2.php';
     echo "
               <div class=\"page-header\" style=\"text-align: center\">
            <h1>Регистрация
                <small>
                    <p>
                        <span class=\"glyphicon glyphicon-pencil\"> заполнение обязательно</span>
                    </p>
                    <p>
                        <span class=\"glyphicon glyphicon-question-sign\"> заполнение по желанию</span>
                    </p>
                </small>
            </h1>
        </div>
        <form class=\"form-register\" method=\"post\" action=\"reg.php\">
            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Логин\" name=\"username\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"password\" class=\"form-control\" placeholder=\"Пароль\" name=\"password\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы английского алфавита и цифры\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-pencil\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"E-mail\" name=\"email\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"pochta123@mail.ru\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Фамилия\" name=\"last_name\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы русского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Имя\" name=\"first_name\"
                       data-toggle=\"tooltip\" data-placement=\"right\" title=\"Только буквы руского алфавита\">
            </div>

            <div class=\"input-group input-group-lg\">
                <span class=\"input-group-addon\">
                    <span class=\"glyphicon glyphicon-question-sign\"> </span>
                </span>
                <input type=\"text\" class=\"form-control\" placeholder=\"Отчество\" name=\"second_name\"
                        data-toggle=\"tooltip\" data-placement=\"right\" title=\"Тoлько буквы русского алфавита\">
            </div>
            <p></p>
            <div class=\"row\">
                <div class=\"col-md-4\"></div>
                <div class=\"col-md-4\"><button type=\"submit\" class=\"btn btn-default btn-lg\" style=\"align-content: center\"  >Регистрация</button></div>
                <div class=\"col-md-4\"></div>
            </div>
        </form>";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
