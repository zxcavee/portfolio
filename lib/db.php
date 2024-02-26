<?php

function connectDB() {
    $servername = "127.0.0.1:3306";
    $username = "root";
    $password = "";
    $dbname = "porftolio3";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function getDBRecordsByQuery($table = 'users', $searchQuery = '') {

    $conn = connectDB();

    $sql = "SELECT * FROM ".$table." ".$searchQuery;
    $result = $conn->query($sql);

    $rows = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    $conn->close();

    return $rows;
}

function updateDBRecord($table = 'users', $user, $fio, $education, $achievements, $institution, $imageName) {

    $conn = connectDB();

    $sql = "UPDATE $table SET fio=?, education=?, achievements=?, institution=?";
    $params = array($fio, $education, $achievements, $institution);

    // Проверяем, есть ли изображение для обновления
    if (!empty($imageName)) {
        $sql .= ", image=?";
        $params[] = $imageName;  // Добавляем изображение в параметры
    }

    $sql .= " WHERE login=?";
    $params[] = $user;  // Предполагается, что $user - это идентификатор записи

    $stmt = $conn->prepare($sql);

    // Используем переменные параметры для bind_param
    $types = str_repeat('s', count($params));  // Создаем строку типов параметров

    if (!$stmt->bind_param($types, ...$params) || !$stmt->execute()) {
        header("Location: /index.php?page=page-result&message=Ошибка при обновлении записи: " . $conn->error);
    }

    $stmt->close();
    $conn->close();

    header("Location: /index.php?page=page-result&message=Запись успешно обновлена!");
}

function insertDBUser($table = 'users', $login, $password) {
    $error = false;
    $conn = connectDB();

    // Хеширование пароля
    $hashedPassword = md5($password);

    // Подготовка запроса с использованием подготовленных выражений
    $sql = "INSERT INTO $table (login, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Проверка на ошибки при подготовке запроса
    if ($stmt === false) {
        header("Location: /index.php?page=page-result&message=Ошибка при подготовке запроса: ". $conn->error);
        $error = true;
    }

    // Привязка параметров и выполнение запроса
    $stmt->bind_param("ss", $login, $hashedPassword);
    if (!$stmt->execute()) {
        header("Location: /index.php?page=page-result&message=Ошибка при выполнении запроса: ". $stmt->error);
        $error = true;
    }

    // Закрытие подготовленного выражения
    $stmt->close();

    // Закрытие соединения
    $conn->close();

    if ($error) {
        exit();
    }

}