<?php

class RecordsModel extends Model
{
    public function index()
    {
        $this->query('SELECT id, email, name, lastname, last_login from users');
        $rows = $this->resultSet();

        return $rows;
    }
}