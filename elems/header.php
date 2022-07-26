<?php
$header = "";
if(isset($_SESSION['notification'])){
    $header .= "<div class='{$_SESSION['notification']['status']}'>{$_SESSION['notification']['info']}</div>";
    unset($_SESSION['notification']);
}else{
    $header .= "<div></div>";
}

$header .= "<form class='search' action='' method='post'>
        <input type='date' name='date'>
        <input type='submit' value='найти'>
        </form>";
$header .= '<form class="addfile" enctype="multipart/form-data" action="" method="POST">
        <input  type="number" name="id" placeholder="Запись №_" />
        Добавить отчёт: <input style="color: white;
    text-shadow: 1px 1px 5px black, 0 0 1em black;" name="upload_file" type="file" />
        <input type="submit" value="Отправить файл" />
        </form>';
echo $header;
