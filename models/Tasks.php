<?php

class TasksModel extends Model
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

    public function add()
    {
        $this->query("SELECT projects.id as project_id, projects.name as project_name FROM projects where status = '1'");
        $rows['projects'] = $this->resultSet();

        $this->query('SELECT users.id as admin_id, users.name as admin_name, users.lastname as admin_lastname FROM users where roles_id = 1');
        $rows2['admins'] = $this->resultSet();

        $this->query('SELECT users.id as user_id, users.name as user_name, users.lastname as user_lastname FROM users where roles_id != 1');
        $rows3['users'] = $this->resultSet();

        $this->query('SELECT attachments.id, attachments.title from attachments where attachments.status = 1');
        $rows4['attachments'] = $this->resultSet();

        $data = array_merge($rows, $rows2, $rows3, $rows4);

        // Sanitizing POST

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $deadline = $post['deadline']. ' ' .$post['deadlinetime'];

        if($post['submit'])
        {
            if($post['name'] == '' || $post['description'] == '' || $post['deadline'] == '' || $post['project_id'] == '' || $post['users_id'] == '')
            {
                Helpers::redirect('/tasks/add','Błąd! Nie uzupełniłes wszystkich danych!', 'error');
            }

            // Insert into DB
            $this->query("INSERT INTO tasks (name, description, start_date, end_date, status, projects_id, users_id)
                          VALUES (:name, :description, current_timestamp, :end_date, '1', :project_id, {$_SESSION['user_data']['id']})");

            $this->bind(':name', $post['name']);
            $this->bind(':description', $post['description']);
            $this->bind(':end_date', $deadline);
            $this->bind(':project_id', $post['project_id']);

            $this->execute();

            $task_id = $this->lastInsertId();

            $users_array = $_POST['users_id'];
            for ($i = 0; $i < count($users_array); $i++)
            {
                $name = $users_array[$i];
                $this->query("INSERT IGNORE INTO users_has_tasks (users_id, tasks_id, status) VALUES (:users_id, :tasks_id, 1)");
                $this->bind(':users_id', $name);
                $this->bind(':tasks_id', $task_id);
                $this->execute();
            }

            $attachments_array = $_POST['attachment'];

            if(isset($attachments_array))
            {
                for ($i = 0; $i < count($attachments_array); $i++)
                {
                    $attachment = $attachments_array[$i];
                    $this->query("INSERT IGNORE INTO tasks_has_attachment (tasks_id, attachments_id) VALUES (:tasks_id, :attachments_id)");
                    $this->bind(':tasks_id', $task_id);
                    $this->bind(':attachments_id', $attachment);
                    $this->execute();
                }
            }

            // verify
            Helpers::redirect('/tasks', 'Utworzyłeś nowe zadanie. o ID: ' . $task_id, 'success');
        }
        unset($_SESSION['posted']);
        return $data;
    }

    public function show()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            // 1. tasks data
            $this->query("SELECT * FROM tasks where id = $id");
            $rows['tasks'] = $this->single();

            // 2. chosen projects name for tasks
            $this->query("SELECT projects.name from tasks inner join projects on tasks.projects_id = projects.id where tasks.id = $id");
            $rows2['projects'] = $this->single();

            // 3. notes
            $this->query("SELECT notes.note, notes.date, users.name, users.lastname FROM notes 
                          INNER JOIN users ON users.id = notes.users_Id WHERE tasks_id = $id");
            $rows3['notes'] = $this->resultSet();

            // 4. All admins which have this task
            $this->query("SELECT users.id, tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id = 1");
            $rows4['admins'] = $this->resultSet();

            $this->query("SELECT users.id, tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id != 1");
            $rows5['users'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 1");
            $rows6['all_admins'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 2 or roles_id = 3");
            $rows7['all_users'] = $this->resultSet();

            $this->query("select attachments.id, attachments.title, tasks_has_attachment.tasks_id from tasks_has_attachment inner join attachments on attachments.id = tasks_has_attachment.attachments_id where tasks_id = :id and attachments.status = 1");
            $this->bind(":id", $id);
            $rows8['attachments'] = $this->resultSet();

            $data = array_merge($rows, $rows2, $rows3, $rows4, $rows5, $rows6, $rows7, $rows8);

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if($post['submit'])
            {
                // Insert into DB
                $this->query("INSERT INTO notes (note, date, users_id, tasks_id) VALUES (:note, current_timestamp, {$_SESSION['user_data']['id']}, $id)");

                $this->bind(':note', $post['note']);

                $this->execute();

                // verify
                if ($this->lastInsertId())
                {
                    Helpers::redirect('/tasks/show/' . $id, 'Dodałes nowy komentarz.', 'success');
                }
            }
        }
        return $data;
    }

    public function edit()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            // 1. tasks data
            $this->query("SELECT * FROM tasks where id = $id");
            $rows['tasks'] = $this->single();

            // 2. chosen projects name for tasks
            $this->query("SELECT projects.name, projects.id from tasks inner join projects on tasks.projects_id = projects.id where tasks.id = $id");
            $rows2['projects'] = $this->single();

            $this->query("SELECT projects.name, projects.id from projects where status = '1'");
            $rows21['all_projects'] = $this->resultSet();

            // 3. notes
            $this->query("SELECT notes.note, notes.date, users.name, users.lastname FROM notes 
                          INNER JOIN users ON users.id = notes.users_Id WHERE tasks_id = $id");
            $rows3['notes'] = $this->resultSet();

            $this->query("SELECT users.id, tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id = 1");
            $rows4['admins'] = $this->resultSet();

            $this->query("SELECT users.id, tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id != 1");
            $rows5['users'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 1");
            $rows6['all_admins'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 2 or roles_id = 3");
            $rows7['all_users'] = $this->resultSet();

            $this->query("select attachments.id, attachments.title, tasks_has_attachment.tasks_id from tasks_has_attachment inner join attachments on attachments.id = tasks_has_attachment.attachments_id where tasks_id = :id and attachments.status = 1");
            $this->bind(":id", $id);
            $rows8['attachments'] = $this->resultSet();

            $this->query('SELECT attachments.id, attachments.title from attachments where attachments.status = 1');
            $rows9['all_attachments'] = $this->resultSet();

            $data = array_merge($rows, $rows2, $rows3, $rows4, $rows5, $rows6, $rows7, $rows8, $rows9, $rows21);

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $deadline = $post['deadline'] . ' ' . $post['deadlinetime'];

            if($post['submit'])
            {
                // Insert into DB
                $this->query("UPDATE tasks SET name = :name, description = :description, end_date = :end_date, projects_id = :projects_id where id = $id");

                $this->bind(':name', $post['name']);
                $this->bind(':description', $post['description']);
                $this->bind(':end_date', $deadline);
                $this->bind(':projects_id', $post['project_id']);

                $this->execute();

                $users_array = $_POST['users_id'];
                for ($i = 0; $i < count($users_array); $i++)
                {
                    $name = $users_array[$i];
                    $this->query("INSERT IGNORE INTO users_has_tasks (users_id, tasks_id) VALUES (:users_id, :tasks_id)");
                    $this->bind(':users_id', $name);
                    $this->bind(':tasks_id', $id);
                    $this->execute();
                }

                $attachments_array = $_POST['attachment'];

                if(isset($attachments_array))
                {
                    for ($i = 0; $i < count($attachments_array); $i++)
                    {
                        $attachment = $attachments_array[$i];
                        $this->query("INSERT IGNORE INTO tasks_has_attachment (tasks_id, attachments_id) VALUES (:tasks_id, :attachments_id)");
                        $this->bind(':tasks_id', $id);
                        $this->bind(':attachments_id', $attachment);
                        $this->execute();
                    }
                }
                // verify
                Helpers::redirect('/tasks/show/' . $id, 'Zaktualizowałeś zadanie.', 'success');
            }
        }
        return $data;
    }

    public function finished()
    {
        $this->query("SELECT tasks.id, tasks.name, tasks.start_date, tasks.end_date, u2.name as users_name, u2.lastname as users_lastname, projects.name as projects_name
                            FROM tasks
                             JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                             JOIN users u1 ON u1.id = users_has_tasks.users_id
                             JOIN projects ON tasks.projects_id = projects.id 
                             JOIN users u2 ON tasks.users_id = u2.id 
                             WHERE users_has_tasks.status = 0 AND u1.id = '{$_SESSION['user_data']['id']}'");
        $rows['users'] = $this->resultSet();

        $this->query("SELECT tasks.id, tasks.name, tasks.start_date, tasks.end_date, u1.id as verify_id, u1.name AS verify_name, u1.lastname AS verify_lastname, u2.name AS users_name, u2.lastname AS users_lastname, projects.name AS projects_name
                    FROM tasks
                    JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                    JOIN users u1 ON u1.id = users_has_tasks.users_id
                    JOIN projects ON tasks.projects_id = projects.id
                    JOIN users u2 ON tasks.users_id = u2.id
                    WHERE users_has_tasks.status = 0");
        $rows2['admins'] = $this->resultSet();

        $data = array_merge($rows, $rows2);

        return $data;
    }

    public function verify()
    {
        $this->query("SELECT tasks.id, tasks.name, tasks.start_date, tasks.end_date, u2.name as users_name, u2.lastname as users_lastname, projects.name as projects_name FROM tasks
                             JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                             JOIN users u1 ON u1.id = users_has_tasks.users_id
                             JOIN projects ON tasks.projects_id = projects.id 
                             JOIN users u2 ON tasks.users_id = u2.id 
                             WHERE users_has_tasks.status = 2 AND u1.id = '{$_SESSION['user_data']['id']}'");
        $rows['users'] = $this->resultSet();

        $this->query("SELECT tasks.id, tasks.name, tasks.start_date, tasks.end_date, u1.id as verify_id, u1.name AS verify_name, u1.lastname AS verify_lastname, u2.name AS users_name, u2.lastname AS users_lastname, projects.name AS projects_name
                    FROM tasks
                    JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                    JOIN users u1 ON u1.id = users_has_tasks.users_id
                    JOIN projects ON tasks.projects_id = projects.id
                    JOIN users u2 ON tasks.users_id = u2.id
                    WHERE users_has_tasks.status = 2");
        $rows2['admins'] = $this->resultSet();

        $data = array_merge($rows, $rows2);

        return $data;
    }

    public function all()
    {
        $this->query("SELECT tasks.id, tasks.name, tasks.start_date, tasks.end_date, u1.name AS users_name, u1.lastname AS users_lastname, u2.name as user_name, u2.lastname as user_lastname, projects.name as projects_name
                            FROM tasks
                             JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                             JOIN users u1 ON u1.id = users_has_tasks.users_id
                             JOIN projects ON tasks.projects_id = projects.id 
                             JOIN users u2 ON tasks.users_id = u2.id 
                             WHERE users_has_tasks.status = 1 OR users_has_tasks.status = 2 ORDER BY tasks.id ASC");
        $rows = $this->resultSet();

        return $rows;
    }
}