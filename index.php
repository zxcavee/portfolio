<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Портал портфолио</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-wrapper">
        <header class="header">
            <div class="top-line">
                <div class="container">
                    <div class="top-line__mode-holder">
                        <?php
                        if (isset($_SESSION['user'])):
                            $modeClass = isset($_SESSION['supervisor']) ? 'admin--mode' : 'user--mode';
                            $modeText = isset($_SESSION['supervisor']) ? 'Режим администратора' : 'Пользовательский режим';
                        else:
                            $modeClass = 'guest--mode';
                            $modeText = 'Гостевой режим';
                        endif;
                        ?>
                        <div class="top-line__mode <?= $modeClass; ?>">
                            <span><?= $modeText; ?></span>
                        </div>
                    </div>
                    <div class="top-line__user">
                        <div class="top-line__user-name">
                            <?php if(isset($_SESSION['user'])):?>
                                <a href="?page=page-update&user=<?= $_SESSION['user'] ?>">
                                    <?= implode(' ', array_slice(explode(' ', $_SESSION['fio']), 0, 2)) ?> <span>(<?= $_SESSION['user'] ?>)</span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="top-line__user-actions">
                            <?php if(!isset($_SESSION['user'])):?>
                                <a href="?page=page-login">
                                    Войти
                                </a>
                            <?php else: ?>
                                <a href="?page=page-logout">
                                    Выйти
                                </a>
                            <?php endif; ?>
                            <span> / </span>
                            <a href="?page=page-register">
                                Загеристрироваться
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="main-menu">
                <div class="container">
                    <ul class="main-menu__list">
                        <li><a href="/" class="main-menu__item <?= !isset($_GET['page'])? 'active' : '' ?>">Главная</a></li>
                        <?php if(isset($_SESSION['supervisor'])):?>
                            <li><a href="?page=page-users" class="main-menu__item <?= $_GET['page'] == 'page-users'? 'active' : '' ?>">Все</a></li>
                        <?php endif; ?>
                        <li><a href="?page=page-request" class="main-menu__item <?= $_GET['page'] == 'page-request'? 'active' : '' ?>">Заявка</a></li>
                        <li><a href="?page=page-update" class="main-menu__item <?= $_GET['page'] == 'page-update'? 'active' : '' ?>">Анкета</a></li>
                        <li><a href="?page=page-contacts" class="main-menu__item <?= $_GET['page'] == 'page-contacts'? 'active' : '' ?>">Контакты</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <main class="page-main">
            <?php
            $page = isset($_GET['page'])? $_GET['page'] : 'page-index' ;
            include $page.'.php';
            ?>
        </main>
        <footer class="footer">
            <div class="container">
                <span>портал для коммерческих портфолио - 2024</span>
            </div>
        </footer>
    </div>
</body>
</html>