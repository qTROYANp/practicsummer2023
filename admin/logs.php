<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_role = $_SESSION['role'];

$stmt = $pdo->prepare("SELECT logs.*, user.id_role, role.name AS role_name FROM logs
LEFT JOIN user ON logs.id_user = user.id_user
LEFT JOIN role ON user.id_role = role.id_role
WHERE user.id_role = ?");
$stmt->execute([$id_role]);
$logData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="title">Логирование</h1>

<? if (!empty($logData)) { ?>

    <table>
        <thead>
            <tr>
                <th>Роль</th>
                <th>Пользователь</th>
                <th>Действие</th>
                <th>Дата и время</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logData as $log) : ?>
                <tr>
                    <td><?php echo $log['role_name']; ?></td>
                    <td><?php echo $log['username']; ?></td>
                    <td><?php echo $log['text']; ?></td>
                    <td><?php echo $log['date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<? } else { ?>
    <p>Данные отсутствуют</p>
<? } ?>


<style>
    .products-table {
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        text-align: left;
    }

    /* Применить стили к четным строкам */
    tr:nth-child(even) {
        background-color: #f2f2f2;
        /* Цвет фона для четных строк */
    }

    /* Применить стили к нечетным строкам */
    tr:nth-child(odd) {
        background-color: #ffffff;
        /* Цвет фона для нечетных строк */
    }
</style>