<?php

class CalendarModel extends Model
{
    public function index()
    {
        $this->query("SELECT tasks.id, tasks.name, tasks.start_date, tasks.end_date, u1.name AS users_name, u1.lastname AS users_lastname, u2.name as user_name, u2.lastname as user_lastname, projects.name as projects_name
                            FROM tasks
                             JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                             JOIN users u1 ON u1.id = users_has_tasks.users_id
                             JOIN projects ON tasks.projects_id = projects.id
                             JOIN users u2 ON tasks.users_id = u2.id
                             WHERE users_has_tasks.status = 1 AND u1.id = '{$_SESSION['user_data']['id']}'");
        $rows = $this->resultSet();

        return $rows;
    }
}