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
include '/menu2.php';

$username = $_SESSION["username"];
$connection_query = $mysqli -> prepare("select * from student where username = ?");
$connection_query -> bind_param("s", $username);
$connection_query -> execute();
$user = $connection_query -> get_result() -> fetch_all(MYSQLI_ASSOC);
?>
<div class="page-header" style="text-align: center">
    <h1>
        Домашняя страница
        <small>
            <p>
                <span class="glyphicon glyphicon-ok"> можете приступить к тестированию</span>
            </p>
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-4 col-md-2"></div>
    <div class="col-xs-10 col-md-8" style="background-color: rgb(243, 243, 243)">
<!--        <ul class="nav nav-tabs">-->
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
                <li style='display: inline-block; margin-right: 7%'class="active">
                    <a href="#home" data-toggle="tab">Мои данные</a>
                </li>
                <li style='display: inline-block; margin-right: 7%'>
                    <a class='tab-link' href="#edit" data-toggle="tab">Редактировать</a>
                </li>
                <li style='display: inline-block; margin-right: 7%'>
                    <a class='tab-link' href="#test" data-toggle="tab">Информация о тестировании</a>
                </li>
                <li style='display: inline-block; margin-right: 7%'>
                    <a href="#logout" data-toggle="tab">Выйти</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="home">

                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">USERNAME:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $user[0]['username'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Имя:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $user[0]['first_name'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Отчество:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $user[0]['second_name'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Фамилия:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $user[0]['last_name'] ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $user[0]['email'] ?></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="edit">
                    <form class="form-edit" method="post" action="home.php" style='width: 80%; margin-left: 10%'>
                        <p></p>
                        <div class="input-group input-group-lg" style='margin-left: 5%; margin-right: 5%'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-pencil"> </span>
                            </span>
                            <input type="text" class="form-control" placeholder="Логин" name="username" data-toggle="tooltip" data-placement="right" title="Только буквы английского алфавита">
                        </div>

                        <div class="input-group input-group-lg" style='margin-left: 5%; margin-right: 5%'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-pencil"> </span>
                            </span>
                            <input type="password" class="form-control" placeholder="Пароль" name="password" data-toggle="tooltip" data-placement="right" title="Только буквы английского алфавита и цифры">
                        </div>

                        <div class="input-group input-group-lg" style='margin-left: 5%; margin-right: 5%'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-pencil"> </span>
                            </span>
                            <input type="text" class="form-control" placeholder="E-mail" name="email" data-toggle="tooltip" data-placement="right" title="pochta123@mail.ru">
                        </div>

                        <div class="input-group input-group-lg" style='margin-left: 5%; margin-right: 5%'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-question-sign"> </span>
                            </span>
                            <input type="text" class="form-control" placeholder="Фамилия" name="last_name" data-toggle="tooltip" data-placement="right" title="Только буквы русского алфавита">
                        </div>

                        <div class="input-group input-group-lg" style='margin-left: 5%; margin-right: 5%'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-question-sign"> </span>
                            </span>
                            <input type="text" class="form-control" placeholder="Имя" name="first_name" data-toggle="tooltip" data-placement="right" title="Только буквы руского алфавита">
                        </div>

                        <div class="input-group input-group-lg" style='margin-left: 5%; margin-right: 5%'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-question-sign"> </span>
                            </span>
                            <input type="text" class="form-control" placeholder="Отчество" name="second_name" data-toggle="tooltip" data-placement="right" title="Тoлько буквы русского алфавита">
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"><button type="submit" class="btn btn-default btn-lg" style="align-content: center"  >Сохранить изменения</button></div>
                            <div class="col-md-4"></div>
                        </div>
                        <p></p>
                    </form>
                </div>
                <div class="tab-pane fade" id="test">
                    <form>
                        <table class="table table-bordered" style="width: 80%; margin-left: 10%">
                            <p></p>
                            <tr class="active">Результаты решенных тестов:</tr>
                            <p></p>
                            <?php
                            //запрос оценки
                            $username = $_SESSION['username'];
                            $connection_query = $mysqli -> prepare("select * from solved_test where username=?");
                            $connection_query -> bind_param("s", $username);
                            $connection_query -> execute();
                            $user = $connection_query -> get_result() -> fetch_assoc();

                            foreach ($user as $row) {
                                for ($i = 1; $i < 15; $i++) {
                                    echo "<tr><td class=\"info\">Тест №" . $i . "</td>";
                                    //  если есть оценка за тест{}
                                    if ($row.['result'] != null) {
                                        if ($row['number_test']==$i) {
                                            if ($row.['result'] >= 90)
                                                echo "<td class=\"success\">" .$row.['result']."%</td>";
                                            elseif ($row.['result'] < 45)
                                                echo "<td class=\"danger\">".$row.['result']."%</td>";
                                            else
                                                echo "<td class=\"warning\">".$row.['result']."%</td>";
                                        } else {
                                            echo "<td class=\"info\">Тест еще не пройден</td>";
                                        }
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                        </table>
                    </form>
                </div>
                <div class="tab-pane fade" id="logout">
                    <div class="page-header">
                        <h1>Вы уверены, что хотите выйти? <small><p><a href='/logout.php'>Да</a></p></small></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>
</body>
</html>
<?php
if ( !empty($_POST) ) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];

    $articles = $mysqli->query("select username from student where username='$username'");
    if ($articles->num_rows == 1) {
        echo "<div class=\"row\">
                <div class=\"col-md-4\"></div>
                <div class=\"col-md-4\"><a href=\"#myModal2\" class=\"btn btn-default btn-lg\" data-toggle=\"modal\"  
        style=\"margin-left: 45%;  margin-top: 20px\" >Что то пошло не так...(такой ник уже есть )</a></div>
                <div class=\"col-md-4\"></div>
            </div>";
    }
    $articles = $mysqli -> query("select  username from student where username='$username'");
    if ($articles -> num_rows == 0) {
        if ((preg_match('[^[a-zA-Z]+$]', $username)) &&
            (preg_match('[^[a-zA-Z0-9._-]{1,20}@[a-zA-Z0-9]{1,10}.[a-zA-Z]{2,6}$]', $email)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $last_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $first_name)) &&
            (preg_match('[^[а-яА-ЯёЁ]+$]u', $second_name))
        ) {
            echo $user[0]['id_student'];
            $connect = $mysqli -> prepare("
            update student set [first_name = ?, second_name = ?, last_name = ?, username = ?, password = ?, email = ?]
            where id_student = (select id_student from student where username= ? )");
            $connect->bind_param("sssssss", $first_name, $last_name, $username, $password, $email, $_SESSION['username']);
            if (!($connect -> execute())) {
                echo $mysqli -> error;
            } else {
                $_SESSION["username"] = $username;
                header('location: /home.php?name=' . $_SESSION['username']);
            }
        } else {
            echo "данные невенрые";
        }
    }
    else {
       echo "пользователь с таким именем уже есть";
    }
} else {
        echo "данные не отправлены";
}
?>
