<?php
include '../config.php';
session_start();

$fid = $_GET['fid'];
$redirect = $_SERVER['HTTP_REFERER'];

$sql1 = "SELECT * from folders where folder_id = $fid";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
  // вывод данных каждой строки
  while($row1 = $result1->fetch_assoc()) {
    $foldername = $row1['folder_name'];
    // После получения имени папки проверить, существует ли папка

    // Получить имя папки для удаления из формы
    $folderNameToDelete = $foldername;

    // Определить директорию, где находится папка
    $directory = "../folders_list/"; // Замени на фактический путь

    // Проверить, существует ли папка в директории
    if (file_exists($directory . $folderNameToDelete)) {
        // Удалить папку из файловой системы
        if (rmdir($directory . $folderNameToDelete)) {
            // Папка удалена из файловой системы, теперь удаляем из базы данных

            // Удалить данные папки из базы данных
            $sql = "DELETE FROM folders WHERE folder_id = $fid";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['folder_deleted'] = "success";
                header("location: $redirect");
            } else {
                echo "Ошибка при удалении папки из файловой системы или базы данных: " . $conn->error;
            }

            // Закрыть соединение с базой данных
            $conn->close();
        } else {
            $_SESSION['error_delete_folder'] = "success";
            header("location: $redirect");
        }
    } else {
        echo "Папка не найдена в файловой системе.";
    }
  }
} else {
  echo "Ошибка при получении имени папки из базы данных.";
}

?>
