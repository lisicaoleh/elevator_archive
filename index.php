<?php

use classes\File;

require 'bin/classes/File.php';
require 'elems/init.php';
require 'bin/classes/CountOfRows.php';
require 'bin/classes/Page.php';

if(!empty($_SESSION['auth'])){

if(isset($_GET['load'])) {
    $file = new File($pdo);
    $file->downloadFile();
}

if(isset($_GET['del'])) {
    $id = $_GET['del'];
    $file = new File($pdo);
    $file->deleteFile($id);
    header('Location: ./');
}

if(!empty($_FILES)) {
    $file = new File($pdo);
    $file->addFile();
}

if(!empty($_COOKIE['id'])){
    $id = $_COOKIE['id'];
    $file = new File($pdo);
    $file->deleteLine($id);
    $_SESSION['notification'] = ["info" => "Удалено",
        "status" => "success"];
    setcookie('id', '');
    header('Location: ./bin/write.php');die();
}
if(isset($_GET['delAll'])) {
    ?>
    <html>
        <script>
            let answer = prompt('Если вы удалите запись, её нельзя будет вернуть!!!\rДля подтверждение напишите "DELETE"');

            if(answer === "DELETE")
            {
                let id = <?php echo $_GET['delAll']; ?>;
                document.cookie = "id="+id;
            }
            document.location.href ="/adminPanel/index.php";

        </script>
    </html>
    <?php
}

$title = 'Главная страница';

$content = $page->getPage();
require 'layout.php';
}else{
    header('Location: ./notif/login.php');
}




