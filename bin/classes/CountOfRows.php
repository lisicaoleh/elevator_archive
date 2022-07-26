<?php

namespace classes;

use PDO;
class CountOfRows
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function write(): void
    {
        $pdo = $this->pdo;
        $sql = 'SELECT COUNT(*) FROM accident';
        $query = $pdo->query($sql);
        $row = $query->fetch(PDO::FETCH_NUM);
        file_put_contents(__DIR__.'/rows');
        file_put_contents(__DIR__.'/rows', $row[0]);
    }

    public function read(): int
    {
        return (int)file_get_contents(__DIR__.'/rows');
    }

    public function getCount(): int
    {
        $pdo = $this->pdo;
        $sql = 'SELECT COUNT(*) FROM accident';
        $query = $pdo->query($sql);
        $row = $query->fetch(PDO::FETCH_NUM);
        return $row[0];
    }
}

$row = new CountOfRows($pdo);


