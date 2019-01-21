<?php

class CalendarModel extends Model
{
    public function index()
    {
        $this->query('SELECT * FROM tasks');
        $rows = $this->resultSet();

        return $rows;
    }
}