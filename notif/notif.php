<?php
session_start();
if(!empty($_SESSION['auth'])) {


    function validation()
    {
        if (!isset($_POST['title']) || !isset($_POST['body'])) {
            return 0;
        }
        if (strlen($_POST['title']) > 35) {
            $_SESSION['notification'] = ["info" => '* тема не может превышать 35 символов',
                "status" => "error"];
            return 0;
        }
        if (strlen($_POST['body']) > 300) {
            $_SESSION['notification'] = ["info" => '* сообщение не может превышать 300 символов',
                "status" => "error"];
            return 0;
        }
        return 1;
    }

    if (validation()) {

        function notify($to, $data): string
        {
            $api_key = "";

            $url = "https://fcm.googleapis.com/fcm/send";
            $fields = json_encode(array('to' => $to, 'notification' => $data, 'topic' => 'TopicName'));
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

            $headers = array();
            $headers[] = 'Authorization: key =' . $api_key;
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return $result;
        }

        $to = "/topics/TopicName";
        $data = array(
            'title' => $_POST['title'],
            'body' => $_POST['body']
        );
        notify($to, $data);
        $_SESSION['notification'] = ["info" => "Сообщение отправлено",
            "status" => "success"];
        header('Location: ./notif.php');die();
    } else {
        $notifTitle = isset($_POST['title']) ? $_POST['title'] : '';
        $notifBody = isset($_POST['body']) ? $_POST['body'] : '';
        $content = "<form class='notif' action='' method='post'>";
        if(isset($_SESSION['notification'])){
            $content .= "<p class='{$_SESSION['notification']['status']}'>{$_SESSION['notification']['info']}</p><br>";
            unset($_SESSION['notification']);
        }
        $content .= "До 35 символов:<br><input class='title' type = 'text' name='title' value='$notifTitle' placeholder='тема'><br>
        До 300 символов:<br><textarea name='body' placeholder='сообщение'>$notifBody</textarea><br>
        <input type = 'submit' value = 'отправить'>
    </form>";
    }
    $href = "<div class='topnav'>
            <a href='../index.php'>На главную</a>
            <a class='active' href='notif.php'>Сообщение</a>
            <a href='logout.php'>Выйти</a>
        </div>";
    require 'layout.php';
}else{
    header('Location: login.php');
}