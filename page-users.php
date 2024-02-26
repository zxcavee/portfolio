<?php
session_start();

include('./lib/db.php');

$rows = getDBRecordsByQuery();

?>
<div class="container">
    <div class="page-content">
        <div class="container-form">
            <div class="page-title">
                <h1>Все</h1>
            </div>
            <?php if(!isset($_SESSION['user'])):?>
                <div class="page-text">
                    <p>Страница доступна только для авторизованных пользователей.</p>
                </div>
            <?php else: ?>
            <div class="page-text">
                <?php if (count($rows) > 0): ?>
                    <div class="table-wrapper">
                        <table class="table-a">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Пользователь</th>
                                    <th>Ф.И.О.</th>
                                    <th>Фото</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><a href="?page=page-update&user=<?= $row['login'] ?>"><?= $row['login'] ?></a></td>
                                    <td><a href="?page=page-update&user=<?= $row['login'] ?>"><?= $row['fio'] ?></a></td>
                                    <td><img src="/uploads/<?= $row['image'] ?>" alt="Фото"></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Нет данных для отображения.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
