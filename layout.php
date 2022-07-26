<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style.css?v=2"/>
</head>
<body>
<header>
    <div class="topnav">
        <a class="active" href='index.php'>На главную</a>
        <a href='notif/notif.php'>Сообщение</a>
        <a href="notif/logout.php">Выйти</a>
    </div>
    <div class="mainpan">
        <h1> Система мониторинга </h1>

        <?php require 'elems/header.php'; ?>
    </div>
</header>
<main>

    <?php echo $content; ?>

</main>
<footer>
</footer>

<div class="result result_hide">
    <button class="result__btn">
        <a class="result__btn-href" href="bin/write.php">Скрыть</a></button><!--дабавить новое количество в файл-->
    <div class="result__message">С момента прошлого входа произошёл инцидент</div>
</div>
<script>
    const countDefault = "<?php echo $row->read();?>"; // количество строк с файла

    const resultElem = document.querySelector('.result');
    const btnElem = document.querySelector('.result__btn');

    let intervalId;

    function checkCritick() {
        let countOfRowsNew = '<?php echo $row->getCount();?>';//количесво строк с базы
        return  +countDefault < +countOfRowsNew;
    }

    function renderMessage() {
        clearInterval(intervalId);
        resultElem.classList.remove('result_hide');
    }

    function start() {
        console.log(checkCritick());
        if (checkCritick()) {
            renderMessage();
        }
    }

    function onClick() {
        resultElem.classList.add('result_hide');
        intervalId = start();
    }

    intervalId = start();
    btnElem.addEventListener('click', onClick);

</script>
</body>
</html>
