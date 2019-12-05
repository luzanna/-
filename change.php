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
        Домашняя
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
if(!empty($_POST))
{
    $username = $_POST["username"];
    $password = password_hash($_POST["password"],PASSWORD_BCRYPT);
    $email = $_POST["email"];
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];

    $articles = $mysqli->query("select  username from student where username='$username'");
    if ($articles->num_rows == 1)
    {
        echo "<div class=\"row\">
                <div class=\"col-md-4\"></div>
                <div class=\"col-md-4\"><a href=\"#myModallogin\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\"  
        style=\"margin-left: 45%;  margin-top: 20px\" >Что то пошло не так...</a></div>
                <div class=\"col-md-4\"></div>
            </div>";
    }
    $articles = $mysqli->query("select  username from student where username='$username'");
    if ($articles->num_rows == 0)
    {
        if ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $last_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $first_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $second_name))
        ) {
            $connect = $mysqli->prepare("insert into student VALUES (DEFAULT, ?,?,?,?,?,?,1) 
            where id_student=(select id_student from student where username={$_SESSION['username']} )");

            $connect->bind_param("ssssss", $first_name, $second_name, $last_name, $username, $password, $email);

            if (!($connect->execute())) {
                echo $mysqli->error;
            } else {
                echo "изменения сохранены";
//                $_SESSION["username"] = $username;
//                header('location: /change.php?name=' . $_SESSION['username']);
            }
        } elseif ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $last_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $first_name))
        ) {
            $connect = $mysqli->prepare("

update student set (first_name=?, second_name=?, last_name=?, username=?, password=?, email=?)
            where id_student=(select id_student from student where username=? )");
            $connect->bind_param("sssss", $first_name, $last_name, $username, $password, $email, $_SESSION['username']);

            if (!($connect->execute())) {
                echo $mysqli->error;
            } else {
                echo "изменения сохранены";
//                $_SESSION["username"] = $username;
//                header('location: /change.php?name=' . $_SESSION['username']);
            }
        } elseif
        ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email))
        )
        {
            $connect = $mysqli->prepare("insert into student VALUES (DEFAULT, NULL ,NULL ,NULL ,?,?,?,1)
            where id_student=(select id_student from student where username={$_SESSION['username']} )");
            $connect->bind_param("sss", $username, $password, $email);

            if (!($connect->execute())) {
                echo $mysqli->error;
            } else {
                echo "изменения сохранены";
//                $_SESSION["username"] = $username;
//                header('location: /change.php?name=' . $_SESSION['username']);
            }
        }
        else
        {
            include '/menu2.php';
            echo "   <div class=\"page-header\" style=\"text-align: center\">
    <h1>Домашняя страница
        <small>
            <p>
                <span class=\"glyphicon glyphicon-ok\"> можете приступить к тестированию</span>
            </p>
        </small>
    </h1>
</div>";

    echo "
    <div class=\"row\">
        <div class=\"col-xs-4 col-md-2\"></div>
        <div class=\"col-xs-10 col-md-8\" style=\"background-color: rgb(243, 243, 243)\">
            <ul class=\"nav nav-tabs\">
                
                
                <li class=\"active\">
                    <style>
                        #form-container1 {display: none}
                    </style>
                    <a href=\"/change.php?user=$username/#form-container1\" id=\"trigger1\">Мои данные</a>
                </li>
                <li><a href=\"/change.php/test?$username\">Информация о тестировании</a></li>
                <li>
                    <style>
                        #form-container2 {display: none}
                    </style>
                    <a href=\"/change.php?$username/#form-container2\" id=\"trigger2\">Редактировать</a>
                </li>
                <li><a href=\"/logout.php\">Выйти</a></li>
            </ul >
        </div>
        <div class=\"row\">
            <div class=\"col-xs-5 col-md-3\"></div>
            <div class=\"col-xs-8 col-md-6\" style=\"background-color: rgb(243, 243, 243); height: 500%\">
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
        </form>
                </div>
            </div>            
        </div>
    </div>";




        }
    }
    else
    {
        include '/menu2.php';
        echo "   <div class=\"page-header\" style=\"text-align: center\">
    <h1>Домашняя страница
        <small>
            <p>
                <span class=\"glyphicon glyphicon-ok\"> можете приступить к тестированию</span>
            </p>
        </small>
    </h1>
</div>";

        echo "
    <div class=\"row\">
        <div class=\"col-xs-4 col-md-2\"></div>
        <div class=\"col-xs-10 col-md-8\" style=\"background-color: rgb(243, 243, 243)\">
            <ul class=\"nav nav-tabs\">
                
                
                <li class=\"active\">
                    <style>
                        #form-container1 {display: none}
                    </style>
                    <a href=\"/change.php?user=$username/#form-container1\" id=\"trigger1\">Мои данные</a>
                </li>
                <li><a href=\"/change.php/test?$username\">Информация о тестировании</a></li>
                <li>
                    <style>
                        #form-container2 {display: none}
                    </style>
                    <a href=\"/change.php?$username/#form-container2\" id=\"trigger2\">Редактировать</a>
                </li>
                <li><a href=\"/logout.php\">Выйти</a></li>
            </ul >
        </div>
        <div class=\"row\">
            <div class=\"col-xs-5 col-md-3\"></div>
            <div class=\"col-xs-8 col-md-6\" style=\"background-color: rgb(243, 243, 243); height: 500%\">
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
        </form>
                </div>
            </div>            
        </div>
    </div>";
    }
}
else
{
    if(isset($_SESSION['username']))
    {
        header('location: /change.php');
    }
    else
        include '/menu2.php';
    echo "   <div class=\"page-header\" style=\"text-align: center\">
    <h1>Домашняя страница
        <small>
            <p>
                <span class=\"glyphicon glyphicon-ok\"> можете приступить к тестированию</span>
            </p>
        </small>
    </h1>
</div>";

    echo "
    <div class=\"row\">
        <div class=\"col-xs-4 col-md-2\"></div>
        <div class=\"col-xs-10 col-md-8\" style=\"background-color: rgb(243, 243, 243)\">
            <ul class=\"nav nav-tabs\">
                
                
                <li class=\"active\">
                    <style>
                        #form-container1 {display: none}
                    </style>
                    <a href=\"/change.php?user=$username/#form-container1\" id=\"trigger1\">Мои данные</a>
                </li>
                <li><a href=\"/change.php/test?$username\">Информация о тестировании</a></li>
                <li>
                    <style>
                        #form-container2 {display: none}
                    </style>
                    <a href=\"/change.php?$username/#form-container2\" id=\"trigger2\">Редактировать</a>
                </li>
                <li><a href=\"/logout.php\">Выйти</a></li>
            </ul >
        </div>
        <div class=\"row\">
            <div class=\"col-xs-5 col-md-3\"></div>
            <div class=\"col-xs-8 col-md-6\" style=\"background-color: rgb(243, 243, 243); height: 500%\">
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
        </form>
                </div>
            </div>            
        </div>
    </div>";
}
?>





<script>
    document.getElementById('trigger1').onclick = function() {
        document.getElementById('form-container1').style.display = 'block';
    }
</script>

<script>
    document.getElementById('trigger2').onclick = function() {
        document.getElementById('form-container2').style.display = 'block';
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>