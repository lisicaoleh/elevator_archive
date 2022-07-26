<?php
require '../elems/init.php';

if(isset($_POST['password'])){
    if(md5($_POST['password']) == '4a7d1ed414474e4033ac29ccb8653d9b') {
        $_SESSION['auth'] = true;
        $_SESSION["notification"] = [
            'info' => 'you login successfully',
            'status' => 'success'];
        header('Location: ../index.php');
        die();
    }else{
        $_SESSION["notification"] = [
            'info' => '* неправильный пароль',
            'status' => 'error'];
        header('Location: ./login.php');
        die();
    }
}else{
    $content = "<form class='login' method='post'>
        <input type = 'password' name = 'password'>
        <input type = 'submit' value = 'login'>";

    if(isset($_SESSION['notification'])){
        $content .= "<p class='{$_SESSION['notification']['status']}'>{$_SESSION['notification']['info']}</p>";
        unset($_SESSION['notification']);
    }
    $content .= "</form>";
}
$href = "<div class='topnav'>
            <a href='../index.php'>На главную</a>
            <a href='notif.php'>Сообщение</a>
            <a class='active' href=''>Войти</a>
        </div>";
require 'layout.php';