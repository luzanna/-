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
session_start();
?>
<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Регистрация
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
        <?php
        session_start();
//        include '/menu2.php';
        ?>
        <!-- HTML-код модального окна -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header" style="background: rgb(243, 243, 243);">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Почему не получилось пройти регистрацию?</h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">
                        <p>Возможно, у вас нажата клавиша CapsLock</p>
                        <p>Проверьте раскладку клавиатуры: допускается использование только английского алфавита и цифр.</p>
                        <p>Может Вы уже зарегистрировались?</p>
                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer" style="background: rgb(243, 243, 243);">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <!--                <button type="button" class="btn btn-primary">Сохранить изменения</button>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- HTML-код модального окна -->
        <div id="myModal2" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header" style="background: rgb(243, 243, 243);">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Почему не получилось пройти регистрацию?</h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">
                        <p>Пользователь с таким e-mail или логином уже существует!</p>
                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer" style="background: rgb(243, 243, 243);">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <!--                <button type="button" class="btn btn-primary">Сохранить изменения</button>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- HTML-код модального окна -->
        <div id="myModal3" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header" style="background: rgb(243, 243, 243);">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Почему не получилось пройти регистрацию?</h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">
                        <p>Вы отправили пустую форму! Заполните данные!</p>
                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer" style="background: rgb(243, 243, 243);">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <!--                <button type="button" class="btn btn-primary">Сохранить изменения</button>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header" style="text-align: center">
            <h1>Регистрация
                <small>
                    <p>
                        <span class="glyphicon glyphicon-pencil"> заполнение обязательно</span>
                    </p>
                    <p>
                        <span class="glyphicon glyphicon-question-sign"> заполнение по желанию</span>
                    </p>
                </small>
            </h1>
        </div>
        <?php
        echo "
        
        <div id=\"form-container1\">
            <div class=\"container-fluid\">".$user[0]['first_name']."</div>
            <div class=\"container-fluid\">".$user[0]['second_name']."</div>
            <div class=\"container-fluid\">".$user[0]['last_name']."</div>
            <div class=\"container-fluid\">".$user[0]['email']."</div>
        </div>
        <div id=\"form-container2\">
            <form class=\"form-edit\" method=\"post\" action=\"change.php\">
                <p></p>
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
            <div class=\"col-md-4\"><button type=\"submit\" class=\"btn btn-default btn-lg\" style=\"align-content: center\"  >Сохранить изменения</button></div>
            <div class=\"col-md-4\"></div>
        </div>
        <p></p>
        </form>";?>

        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
