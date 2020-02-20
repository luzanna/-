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
            Тестирование
        </title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">


        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]-->
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <!--[endif]--><!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    </head>
    <body>
    <?php
    session_start();

    $number_test = $_GET["number_test"];
    $connection_query = $mysqli -> prepare("select * from test where number_test = ?");
    $connection_query -> bind_param("i", $number_test);
    $connection_query -> execute();
    $question_test = $connection_query->get_result()->fetch_all(MYSQLI_ASSOC);
    $result = count($question_test);

    include '/menu2.php';
    $c=count($_POST);

    if (!empty($_POST) && $c==$result) {
        echo "    
        <div class=\"page-header\" style=\"text-align: center\">
            <h1>
                Тестирование
                <small>
                    <p>
                        <span class=\"glyphicon glyphicon-ok\"> здесь можно проверить свои знания</span>
                    </p>
                </small>
            </h1>
        </div>
        <form class=\"form-test-\" method=\"post\" action=\"test.php?number_test=$number_test\">
            <div class=\"row\">
                <div class=\"col-xs-5 col-md-3\"></div>
                <div class=\"col-xs-8 col-md-6\" style=\"background-color: rgb(243, 243, 243)\">
                
            <h3 style = 'margin-left: 10%; text-align: center' > Тест №" . $question_test[0]['number_test'] . ". Результаты </h3 >";
        $mark = 0;
        // для первого теста номер вопроса совпадает, для следующих нет
        $i=1;
        foreach ($question_test as $row) {
            var_dump($_POST);
            echo "<p></p>";
            var_dump( $row['answer_right'] );
            if ($_POST["answer_{$row['id_test']}"] == null) {
                $_POST["answer_{$row['id_test']}"]='Вы пропустили этот вопрос';
            }
            if ($_POST["answer_{$row['id_test']}"]==$row['answer_right']) {
                    echo "
                    <div class='jumbotron' style=\"background-color: rgba(143, 243, 168, 0.5)\">
                        <h3 style='margin-left: 10%; text-align: center'>Вопрос №" . $i . "</h3>
                        <div class=\"container-fluid\" style='margin-left: 10%; text-align: center'>" . $row['question'] . "</div>
                        <hr>
                        <div class=\"container-fluid\">
                            <span class=\"container-fluid-addon\">
                                Ваш ответ верный: " . $row['answer_right'] . "
                            </span>
                        </div>
                        <hr>
                        </div>";
                    $mark += 1;
                } else {
                    echo "
                        <div class='jumbotron' style=\"background-color: rgba(243, 201, 212, 0.5)\">
                            <h3 style='margin-left: 10%; text-align: center'>Вопрос №" . $i . "</h3>
                            <div class=\"container-fluid\" style='margin-left: 10%; text-align: center'>" . $row['question'] . "</div>
                            <hr>
                            <div class=\"container-fluid\" >
                                <span class=\"container-fluid-addon\"> Првильный ответ:
                                    " . $row['answer_right'] . "
                                </span>
                            </div>
                            <hr>
                            <div class=\"container-fluid\">
                                <span class=\"container-fluid-addon\">
                                    Ваш ответ: " . $_POST["answer_{$row['id_test']}"] . "
                                </span>
                            </div>
                            <hr>
                        </div>"
                    ;
                }
            $i++;
        }

        $p = round($mark/$result*100);
        echo "
        <div class='jumbotron' style=\"background-color: rgba(132, 178, 243, 0.5)\">
            <h3 style='margin-left: 10%; text-align: center'>Результаты " . $number_test . " теста:</h3>
            <hr>
            <div class=\"container-fluid\" >
                <span class=\"container-fluid-addon\" > 
                   <h3 style=\"text-align: center\"> $mark правильных ответов из $result вопросов</h3> 
                   <h3 style=\"text-align: center\"> или</h3>
                   <h3 style=\"text-align: center\">  $p%</h3>
                </span>
            </div>
            <hr>
        </div>
        ";
        $username = $_SESSION['username'];
        $res = $mysqli -> query("select id_student from student where username='$username'");
        $id_student = $res -> fetch_assoc();
        $var2 = $mysqli -> query("SELECT COUNT(number_test) FROM solved_test WHERE (number_test = '$number_test' and id_student = '$id_student')");
        $var3 = $var2 -> fetch_assoc();
        var_dump($var2);
        if ($var2 == 0) {
            $connection_query = $mysqli -> prepare("insert into solved_test VALUES ( DEFAULT , ? , ? , ?)");
            $connection_query -> bind_param("iii", $number_test, $id_student['id_student'], $p);
            $connection_query -> execute();
            $test = $connection_query -> get_result() -> fetch_assoc(MYSQLI_ASSOC);
        } else {
            $connection_query = $mysqli -> prepare("UPDATE solved_test SET result = ? WHERE (id_student = '$id_student' and number_test = '$number_test')");
            $connection_query -> bind_param("i", $p);
            $connection_query -> execute();
            $test = $connection_query -> get_result() -> fetch_assoc(MYSQLI_ASSOC);
        }
    } else {
        if ($c<$result && $c!=0) {
            var_dump($_POST);
            echo "нужно ответить на все вопросы";}
            echo "    
            <div class=\"page-header\" style=\"text-align: center\">
                <h1>
                    Тестирование
                    <small>
                        <p>
                            <span class=\"glyphicon glyphicon-ok\"> здесь можно проверить свои знания</span>
                        </p>
                    </small>
                </h1>
            </div>
            <!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
            <form class=\"form-test\" method=\"post\" action=\"test.php?number_test=$number_test\">
            <div class=\"row\">
                <div class=\"col-xs-5 col-md-3\"></div>
                <div class=\"col-xs-8 col-md-6\" style=\"background-color: rgb(243, 243, 243)\">";

        $s = 1;
        echo "
             <h3 style='margin-left: 10%; text-align: center'>Тест №" . $question_test[0]['number_test'] . "</h3>";
        foreach ($question_test as $row) {
            $p = $s / $result * 100;
            if (stristr($row['question'], '______')) {
                echo "<div class='jumbotron'>
                        <h3 style='margin-left: 10%; text-align: center'>Вопрос №" . $s . "</h3>
                        <div class=\"progress\" style=\"\margin-outside: 10px\">
                            <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=$p% 
                                aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $p%;\">
                                <span class=\"sr-only\"> 60%</span>
                            </div>
                        </div>
                        <div class=\"container-fluid\" style='margin-left: 10%; text-align: center'>" . $row['question'] . "</div>
                        
                        <div class=\"input-group\">
                            <input type=\"text\" class=\"form-control\" name=\"answer_{$row['id_test']}\" style='width: 335%'>
                        </div><!-- /input-group --> 
                        
                        </div>";

                if ($s == $result) {
                    echo "
                        <form class=\"form-test-answer\" method=\"get\" action=\"test.php?number_test=$number_test\">
                            <button type=\"submit\" class=\"btn btn-default\" >Закончить тест</button><p></p>
                            </form>";
                }

            } else {
                echo "<div class='jumbotron'>
                        <h3 style='margin-left: 10%; text-align: center'>Вопрос №" . $s . "</h3>
                        <div class=\"progress\" style=\"\margin-outside: 10px\">
                            <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=$p% 
                                aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $p%;\">
                                <span class=\"sr-only\"> 60%</span>
                            </div>
                        </div>
                        <div class=\"container-fluid\" style='margin-left: 10%; text-align: center'>" . $row['question'] . "</div>
                        <hr>
                        
                        <div class=\"container-fluid\">
                            <span class=\"container-fluid-addon\">
                                <input type=\"radio\" name=\"answer_{$row['id_test']}\" value=\"{$row['answer_right']}\">
                            </span>
                        " . $row['answer_right'] . "
                        </div>
                        <hr>";
                if ($row['answer2'] != null){
                        echo" 
                        <div class=\"container-fluid\">
                            <span class=\"container-fluid-addon\">
                                <input type=\"radio\" name=\"answer_{$row['id_test']}\" value=\"{$row['answer2']}\">
                            </span>" . $row['answer2'] . "</div>
                        <hr>";}
                    if ($row['answer3']!=null){
                        echo"
                        
                        <div class=\"container-fluid\">
                            <span class=\"container-fluid-addon\">
                                <input type=\"radio\" name=\"answer_{$row['id_test']}\" value=\"{$row['answer3']}\">
                            </span>" . $row['answer3'] . "</div>
                        <hr>";
                    }
                    if ($row['answer4']!=null){
                            echo"
                        <div class=\"container-fluid\">
                            <span class=\"container-fluid-addon\">
                                <input type=\"radio\" name=\"answer_{$row['id_test']}\" value=\"{$row['answer4']}\">
                            </span>" . $row['answer4'] . "</div> 
                        <hr>";
                    }
                echo "
                        </div>"
                ;

                if ($s == $result) {
                    echo " <form class=\"form-test-answer\" method=\"get\" action=\"test.php?number_test=$number_test\">
                             <button type=\"submit\" class=\"btn btn-default\" number_test='$number_test'>Закончить тест</button>
                             <p></p>
                             </<form>";
                }
            }
            $s += 1;

        }
    }
?>
        </div>
    </div>
</form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
