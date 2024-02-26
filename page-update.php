<?php

session_start();

include('./lib/db.php');

// Получение имени пользователя из сессии
if(isset($_SESSION['supervisor']) && isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    $user = $_SESSION['user'];
}

// Получение данных из таблицы

$rows = getDBRecordsByQuery('users', "WHERE login='$user'");

// Проверка наличия данных
if (count($rows) === 1) {

    // Заполнение полей формы данными из таблицы
    $fioValue = $rows[0]['fio'];
    $educationValue = $rows[0]['education'];
    $achievementsValue = $rows[0]['achievements'];
    $institutionValue = $rows[0]['institution'];
    $imagePath = $rows[0]['image'];

} else {
    // Если данные не найдены, установите значения по умолчанию
    $fioValue = '';
    $educationValue = '';
    $achievementsValue = '';
    $institutionValue = '';
}
?>

<div class="container">
    <div class="page-content">
        <div class="container-form">
            <div class="page-title">
                <h1>Анкета</h1>
            </div>
            <?php if(!isset($_SESSION['user'])):?>
                <div class="page-text">
                    <p>Страница доступна только для авторизованных пользователей.</p>
                </div>
            <?php else: ?>
                <div class="page-text">
                    <form method="post" action="lib/update.php" enctype="multipart/form-data">
                        <input type="hidden" name="user" value="<?= $user ?>">
                        <input type="text" name="fio" placeholder="Фамилия Имя Отчество" required value='<?= $fioValue; ?>'><br>
                        <input type="text" name="education" placeholder="Образование" required value='<?= $educationValue; ?>'><br>
                        <input type="text" name="achievements" placeholder="Достижения" required value='<?= $achievementsValue; ?>'><br>
                        <input type="text" name="institution" placeholder="Учебное заведение" required value='<?= $institutionValue; ?>'><br>

                        <?php if (!empty($imagePath)): ?>
                        <img src="./uploads/<?= $imagePath ?>" alt="Фото"><br>
                        <?php endif; ?>

                        <input type="file" name="image" id="image" accept=".jpg, .png"><br>

                        <button type="submit">Отправить форму</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
