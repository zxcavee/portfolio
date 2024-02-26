<?php
session_start();

include('db.php');

// Проверка, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $user = $_POST['user'];
    $fio = $_POST['fio'];
    $education = $_POST['education'];
    $achievements = $_POST['achievements'];
    $institution = $_POST['institution'];

    // Обработка загрузки изображения
    if(!empty($_FILES['image']['name'])) {
        $uploadDirectory = '../uploads/';
        $originalImageName = $_FILES['image']['name'];
        $originalImagePath = $uploadDirectory . $originalImageName;
        $imageFileType = pathinfo($originalImagePath, PATHINFO_EXTENSION);

        // Генерация уникального имени файла, чтобы избежать перезаписи
        $imageName = uniqid('image_') . '.' . $imageFileType;
        $imagePath = $uploadDirectory . $imageName;

        $uploadResult = move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    } else {
        $imageName = '';
    }

    // Обновление строки в базе данных
    updateDBRecord('users', $user, $fio, $education, $achievements, $institution, $imageName);

} else {
    header("Location: /index.php");
}

exit();
