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
            Учебник
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
    ?>

    <div class="page-header" style="text-align: center">
        <h1>Учебник</h1>
    </div>
    
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <div class="container">

        <div class="jumbotron"><!--    <ul class="pager">-->
<!--        <li><a href="#">Предыдущая</a></li>-->
<!--        <li><a href="#">Следующая</a></li>-->
<!--    </ul>-->

        <?php
        
        $number_chapter = $_GET["number_chapter"];

        $connection_query = $mysqli->prepare("select * from book where number_chapter = ?");
        $connection_query->bind_param("i", $number_chapter);
        $connection_query->execute();
        $chapter_text = $connection_query->get_result()->fetch_all(MYSQLI_ASSOC);
        echo
            "
 <div class=\"page-header\" style=\"text-align: center\">
        <h2>Глава ".$chapter_text[0]['number_chapter']."</h2>
        
    </div>

    <div class=\"row\">
  <div class=\"col-md-6\">.col-md-6</div>
  <div class=\"col-md-6\">.col-md-6</div>
</div>
    
        <span>текст главы:</span>
                <span>".$chapter_text[0]['chapter_text']."</span>
        
        </div>
        
    </div>";
?>
    </body>
    </html>


