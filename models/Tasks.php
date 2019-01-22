<?php

class TasksModel extends Model
{
    public function index()
    {
        $this->query("SELECT tasks.id as tasks_id, tasks.name as tasks_name, tasks.start_date, tasks.end_date, tasks.projects_id, tasks.users_id, projects.id as projects_id, projects.name as projects_name, users.name as users_name, users.lastname as users_lastname FROM tasks INNER JOIN projects ON tasks.projects_id = projects.id INNER JOIN users ON tasks.users_id = users.id WHERE tasks.status = '1' AND tasks.users_id = {$_SESSION['user_data']['id']}");
        $rows = $this->resultSet();
        return $rows;
    }

    public function add()
    {
        $this->query('SELECT projects.id as project_id, projects.name as project_name FROM projects');
        $rows['projects'] = $this->resultSet();

        $this->query('SELECT users.id as admin_id, users.name as admin_name, users.lastname as admin_lastname FROM users where roles_id = 1');
        $rows2['admins'] = $this->resultSet();

        $this->query('SELECT users.id as user_id, users.name as user_name, users.lastname as user_lastname FROM users where roles_id = 2');
        $rows3['users'] = $this->resultSet();

        $rows4 = Array ($_POST['name'], $_POST['description'], $_POST['deadline'], $_POST['deadlinetime']);

        $data = array_merge($rows, $rows2, $rows3, $rows4);

        // Sanitizing POST

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $deadline = $post['deadline']. ' ' .$post['deadlinetime'];

        if($post['submit'])
        {
            if($post['name'] == '' || $post['description'] == '' || $post['deadline'] == '' || $post['project_id'] == '' || $post['attachment[]'] == 'Wybierz plik')
            {
                $_SESSION['posted'] = $post;
                Helpers::redirect('/tasks/add','Błąd! Nie uzupełniłes wszystkich danych!', 'error');
                return $data;
            }

            // Insert into DB
            $this->query("INSERT INTO tasks (name, description, start_date, end_date, status, projects_id, users_id)
                          VALUES (:name, :description, current_timestamp, :end_date, '1', :project_id, {$_SESSION['user_data']['id']})");

            $this->bind(':name', $post['name']);
            $this->bind(':description', $post['description']);
            $this->bind(':end_date', $deadline);
            $this->bind(':project_id', $post['project_id']);

            $this->execute();

            // verify
            if ($this->lastInsertId())
            {
                Helpers::redirect('/tasks', 'Utworzyłeś nowe zadanie.', 'success');
            }
            return;
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

            $this->query("SELECT tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id = 1");
            $rows4['admins'] = $this->resultSet();

            $this->query("SELECT tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id = 2");
            $rows5['users'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 1");
            $rows6['all_admins'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 2 or roles_id = 3");
            $rows7['all_users'] = $this->resultSet();

            $data = array_merge($rows, $rows2, $rows3, $rows4, $rows5, $rows6, $rows7);

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
                return;
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

            $this->query("SELECT projects.name, projects.id from tasks inner join projects on tasks.projects_id = projects.id where projects.id != $id");
            $rows21['all_projects'] = $this->resultSet();

            // 3. notes
            $this->query("SELECT notes.note, notes.date, users.name, users.lastname FROM notes 
                          INNER JOIN users ON users.id = notes.users_Id WHERE tasks_id = $id");
            $rows3['notes'] = $this->resultSet();

            $this->query("SELECT tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id = 1");
            $rows4['admins'] = $this->resultSet();

            $this->query("SELECT tasks.name, users.email, users.name, users.lastname
                            FROM tasks
                            INNER JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id
                            INNER JOIN users ON users.id = users_has_tasks.users_id
                            WHERE tasks.id = $id AND users.roles_id = 2");
            $rows5['users'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 1");
            $rows6['all_admins'] = $this->resultSet();

            $this->query("SELECT users.id, users.name, users.lastname FROM users where roles_id = 2 or roles_id = 3");
            $rows7['all_users'] = $this->resultSet();

            $data = array_merge($rows, $rows2, $rows3, $rows4, $rows5, $rows6, $rows7, $rows21);

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

                // verify
                Helpers::redirect('/tasks/show/' . $id, 'Zaktualizowałeś zadanie.', 'success');
            }
        }
        return $data;
    }
}