<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PUSH-notification</title>
    <link rel="stylesheet" href="style.css?v=32" />
</head>
<body>
<div>
    <header>
        <?php
        if(isset($href)){
            echo $href;
        }
        ?>
        <div class="mainpan">
            <h1> Система мониторинга </h1>
        </div>
    </header>
    <main>
        <div>
        <?php echo $content; ?>
        </div>
    </main>
    <footer>
    </footer>
</div>
</body>
</html>
