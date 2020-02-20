<nav class="navbar navbar-default">
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="/index.php">C++</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Учебник
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="book.php?number_chapter=1" >Введение</a></li>
                        <li><a href="book.php?number_chapter=2">Основы программирования на С++</a></li>
                        <li><a href="book.php?number_chapter=3">Циклы и вертикали</a></li>
                        <li><a href="book.php?number_chapter=4">Структуры</a></li>
                        <li><a href="book.php?number_chapter=5">Функции</a></li>
                        <li><a href="book.php?number_chapter=6">Объекты и классы</a></li>
                        <li><a href="book.php?number_chapter=7">Массивы и строки</a></li>
                        <li><a href="book.php?number_chapter=8">Перезагрузка операций</a></li>
                        <li><a href="book.php?number_chapter=9">Наследование</a></li>
                        <li><a href="book.php?number_chapter=10">Указатели</a></li>
                        <li><a href="book.php?number_chapter=11">Виртуальные функции</a></li>
                        <li><a href="book.php?number_chapter=12">Потоки и файлы</a></li>
                        <li><a href="book.php?number_chapter=13">Многофайловые программы</a></li>
                        <li><a href="book.php?number_chapter=14">Шаблоны и исключения</a></li>
                        <li><a href="book.php?number_chapter=15">Стандартная библиотека шаблонов</a></li>
                        <li><a href="book.php?number_chapter=16">Разработка объектно-ориентированного ПО</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Тестирование
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        if (isset($_SESSION['username'])) {
                        ?>
                            <li><a href = "test.php?number_test=1" > Тест 1 </a ></li >
                            <li><a href = "test.php?number_test=2" > Тест 2 </a ></li >
                            <li><a href = "test.php?number_test=3" > Тест 3 </a ></li >
                            <li><a href = "test.php?number_test=4" > Тест 4 </a ></li >
                            <li><a href = "test.php?number_test=5" > Тест 5 </a ></li >
                            <li><a href = "test.php?number_test=6" > Тест 6 </a ></li >
                            <li><a href = "test.php?number_test=7" > Тест 7 </a ></li >
                            <li><a href = "test.php?number_test=8" > Тест 8 </a ></li >
                            <li><a href = "test.php?number_test=9" > Тест 9 </a ></li >
                            <li><a href = "test.php?number_test=10" > Тест 10 </a ></li >
                            <li><a href = "test.php?number_test=11" > Тест 11 </a ></li >
                            <li><a href = "test.php?number_test=12" > Тест 12 </a ></li >
                            <li><a href = "test.php?number_test=13" > Тест 13 </a ></li >
                            <li><a href = "test.php?number_test=14" > Тест 14 </a ></li >
                            <li><a href = "test.php?number_test=15" > Тест 15 </a ></li >
                            <li><a href = "test.php?number_test=16" > Тест 16 </a ></li >
                        <?php
                        } else {
                        ?>
                            <li class="disabled" ><a href = "#" > Тест 1 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 2 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 3 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 4 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 5 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 6 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 7 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 8 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 9 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 10 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 11 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 12 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 13 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 14 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 15 </a ></li >
                            <li class="disabled" ><a href = "#" > Тест 16 </a ></li >
                        <?php
                         }
                        ?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                       style="margin-right: 10px">
                        <?php
                        if ( isset($_SESSION['username']) )
                            echo $_SESSION['username'];
                        else
                            echo "Личный кабинет";
                        ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        if ( isset($_SESSION['username']) )
                        {
                            $username=$_SESSION['username'];
                            echo " <li><a href=\"home.php?user=$username\">Домой</a></li>
                                    <li><a href=\"logout.php\"> Выйти</a></li>";
                        }
                        else
//                            echo "   <li><a href=\"#myModal\" data-toggle=\"modal\">Войти</a></li>
//                        <li><a href=\"#myModal2\" data-toggle=\"modal\">Зарегистрироваться</a></li>";
                            echo " <li><a href=\"login.php\">войти</a></li>
                                    <li><a href=\"reg.php\"> регистрация</a></li>";
                        ?>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
