<?php

namespace classes;

use PDO;

class File
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function addLinkFile(): void
    {
        $pdo = $this->pdo;
        $id = $_POST['id'];
        $sql = "INSERT INTO `report` (`accident_id`, `path`) VALUES ('$id', '{$_FILES['upload_file']['name']}');";
        $pdo->query($sql);
    }

    public function addFile(): void
    {
        if(empty($_POST['id'])){
            $_SESSION['notification'] = ["info" => 'Вы не выбрали номер!',
                "status" => "error"];
            return;
        }
        $name = $_FILES['upload_file']['name'];
        $filePos = $this->alreadySetFile($name);
        if($filePos) {
            $_SESSION['notification'] = ["info" => 'Файл найден под номером: '.$filePos,
                "status" => "error"];
            return;
        }

        if($this->alreadySetId()) {
            $_SESSION['notification'] = ["info" => '"'.$_POST['id'].'" уже добавлен',
                "status" => "error"];
            return;
        }

        if(!$this->idExist()) {
            $_SESSION['notification'] = ["info" => '"'.$_POST['id'].'" не существует',
                "status" => "error"];
            return;
        }

        $file = "./reports/" . basename($_FILES['upload_file']['name']);
        move_uploaded_file($_FILES['upload_file']['tmp_name'], $file);
        $_SESSION['notification'] = ["info" => "Загруженный файл: " . $_FILES['upload_file']['name'],
            "status" => "success"];
        $this->addLinkFile();
    }

    public function downloadFile(): void
    {
        $pdo = $this->pdo;
        $id = $_GET['load'];
        $sql = "SELECT path FROM report WHERE accident_id = $id";
        $query = $pdo->query($sql);
        if ($row = $query->fetch(PDO::FETCH_OBJ)) {
            $file = "./reports/$row->path";
            header('Content-Disposition: attachment; filename="' . $row->path . '"');
            readfile($file);
        }
    }

    public function deleteFile($id): void
    {
        $pdo = $this->pdo;
        $sql = "SELECT path FROM report WHERE accident_id = $id";
        $query = $pdo->query($sql);

        if($row = $query->fetch(PDO::FETCH_OBJ))
        {
            $sql = "DELETE FROM report WHERE accident_id = $id";
            $pdo->query($sql);
            unlink("./reports/$row->path");
        }
    }

    private function alreadySetFile($name): int
    {
        $pdo = $this->pdo;
        $sql = "SELECT accident_id FROM report WHERE `path` = '$name'";
        $query = $pdo->query($sql);
        $row = $query->fetch(PDO::FETCH_OBJ);

        if($row) {
            return $row->accident_id;
        }else{
            return 0;
        }
    }

    private function alreadySetId(): bool
    {
        $pdo = $this->pdo;
        $sql = "SELECT COUNT(*) FROM report WHERE `accident_id` = '{$_POST['id']}'";
        $query = $pdo->query($sql);
        $row = $query->fetch(PDO::FETCH_NUM);

        return $row[0];
    }

    public function idExist():int
    {
        $pdo = $this->pdo;
        $sql = "SELECT COUNT(*) FROM accident WHERE `id` = '{$_POST['id']}'";
        $query = $pdo->query($sql);
        $row = $query->fetch(PDO::FETCH_NUM);

        return $row[0];
    }

    public function deleteLine($id):void
    {
        $this->deleteFile($id);
        $pdo = $this->pdo;
        $sql = "DELETE FROM accident WHERE id = $id";
        $pdo->query($sql);
        setcookie("id", "");
    }
}