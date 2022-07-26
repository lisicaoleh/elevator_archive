<?php

namespace classes;
class Filter
{
    public function getTime()
    {
        if (!empty($_POST['date'])) {
            $date = strtotime($_POST['date']);
            return $date;
        } else {
            return 0;
        }
    }
}