<?php

namespace classes;

use PDO;

require 'Filter.php';

class Page
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function getReports($pdo): array
    {
        $reports = [];
        $sql = "SELECT * FROM report";
        $query = $pdo->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $reports[] = $row;
        }
        return $reports;
    }

    public function getPage()
    {
        $pdo = $this->pdo;
        $content = "";

        $seachingDate = (new Filter)->getTime();
        if($seachingDate != 0){
            $searchType = "ASC";
        }else{
            $searchType = 'DESC';
        }

        $reports = $this->getReports($pdo);
        $sql = "SELECT id, time FROM accident ORDER BY id $searchType";
        $query = $pdo->query($sql);
        while ($row = $query->fetch(PDO::FETCH_OBJ)) {
            $timestamp = strtotime($row->time) > $seachingDate;

            if ($timestamp) {
                $reportButton = "";
                foreach ($reports as $value) {
                    if ($value['accident_id'] == $row->id) {
                        $reportButton = "<a class='deleteButton' href='/adminPanel/index.php?del={$row->id}'>удалить отчёт</a>
                                        <a class='downloadButton' href='/adminPanel/index.php?load={$row->id}'>скачать отчёт</a>";
                       break;
                    }
                }
                $reportButton .= "<a class='deleteButton' href='/adminPanel/index.php?delAll={$row->id}'>удалить всё</a>";
                $content .= '<div>' . "Запись № " . $row->id . "  Время проишествия: " .
                    $row->time . $reportButton . '</div>';
            }
        }

        $content .= "";
        return $content;
    }
}

$page = new Page($pdo);
