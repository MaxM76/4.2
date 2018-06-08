<?php

    $id = $_GET['id'];
    $action = $_GET['action'];
    $discription = $_GET['discription'];

    switch ($action) {
        case "add":
            $sql = 'INSERT INTO tasks (description, is_done, date_added) VALUES ($discription, \'В процессе\',' . date('Y-m-d H:i:s') . ')';
            break;
        case "delete":
            $sql = 'DELETE FROM tasks WHERE id = $id';
            break;
        case "done":
            $sql = 'UPDATE tasks SET is_done = \'Выполнено\' WHERE id = $id';
            break;
        default:
            $sql = '';
            break;
    }

    $pdo = new PDO(
        "mysql:host=localhost;dbname=mmarkelov",
        "mmarkelov",
        "neto1755",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('SET NAMES utf8');
    $sql = 'SELECT * FROM tasks';
?>


<!DOCTYPE html>
<html lang="ru">
  <head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body>
    <div>
      <h1>Список дел на сегодня</h1>

      <form method="GET">
        <input type="text" name="description" placeholder="Описание задачи" value="">
        <input type="hidden" name="action" value="add">
        <input type="submit" name="save" value="Добавить">
      </form>

      <table>
        <thead>
          <tr>
            <th>Описание задачи</th>
            <th>Дата добавления</th>
            <th>Статус</th>
            <th>Действия</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($pdo->query($sql) as $row) : ?>

          <tr>
            <td><?=$row['description']?></td>
            <td><?=$row['date_added']?></td>

            <?php
                switch ($row['is_done']) {
                    case "В процессе":
                        $color = "red";
                        break;
                    case "Выполнено":
                        $color = "green";
                        break;
                    default:
                        $color = "brown";
                        break;
                }
            ?>
            <td><span style="color: <?=$color?>;"><?=$row['is_done']?></span></td>

            <?php $href = "href=\"?id=" . $row['id'] . "&amp;action="; ?>
            <td>
              <a <?=$href?>done">Выполнить</a>
              <a <?=$href?>delete">Удалить</a>
            </td>
          </tr>
          <?php endforeach;?>

        </tbody>

      </table>
    </div>

  </body>
</html>