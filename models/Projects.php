<?php

class ProjectsModel extends Model
{
    public function index()
    {
        $this->query("SELECT projects.id as projects_id, projects.name, projects.end_date, projects.author_id, users.id as user_id, users.name as user_name, users.lastname as user_lastname FROM projects INNER JOIN users ON projects.author_id = users.id WHERE projects.status = '1'");
        $rows = $this->resultSet();
        return $rows;
    }

    public function add ()
    {
        $this->query('SELECT * FROM attachments');
        $rows = $this->resultSet();

        // Sanitizing POST

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $rows2 = Array ($_POST['name'], $_POST['description'], $_POST['deadline'], $_POST['deadlinetime']);

        $data = $rows2;

        if($post['submit'])
        {
            if($post['name'] == '' || $post['description'] == '' || $post['deadline'] == '' || $post['deadlinetime'] == '')
            {
                $_SESSION['posted'] = $data;
                Helpers::redirect('/projects/add', 'Błąd! Nie uzupełniłes wszystkich danych!', 'error');
                return $data;
            }

            $deadline = $post['deadline']. ' ' .$post['deadlinetime'];

            // Insert into DB
            $this->query("INSERT INTO projects (name, description, start_date, end_date, author_id, status) 
                          VALUES (:name, :description, current_timestamp, :end_date, {$_SESSION['user_data']['id']}, '1')");

            $this->bind(':name', $post['name']);
            $this->bind(':description', $post['description']);
            $this->bind(':end_date', $deadline);

            $this->execute();

            // verify
            if ($this->lastInsertId())
            {
                Helpers::redirect('/projects', 'Utworzyłeś nowy projekt.', 'success');
                unset($_SESSION['posted']);
            }
            return;

            // TODO ATTACHMENTS
        }

        return $data;
    }

    public function show()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            $this->query("SELECT * FROM projects where id = $id");
            $rows = $this->single();
            return $rows;
        }

        header('Location:' . ROOT_URL . '/projects');
    }

    public function edit()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            $this->query("SELECT * FROM projects where id = $id");
            $rows = $this->single();
        }

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $rows2 = Array ($_POST['name'], $_POST['description'], $_POST['deadline'], $_POST['deadlinetime']);

        $data = $rows2;

        if($post['submit'])
        {
            if($post['name'] == '' || $post['description'] == '' || $post['deadline'] == '' || $post['deadlinetime'] == '')
            {
                $_SESSION['posted'] = $data;
                Helpers::redirect('/projects/add', 'Błąd! Nie uzupełniłes wszystkich danych!', 'error');
                return $data;
            }

            $deadline = $post['deadline']. ' ' .$post['deadlinetime'];

            // Insert into DB
            $this->query("UPDATE projects set name = :name, description = :description, end_date = :end_date where id = $id");

            $this->bind(':name', $post['name']);
            $this->bind(':description', $post['description']);
            $this->bind(':end_date', $deadline);

            $this->execute();

            // verify
                Helpers::redirect('/projects/show/' . $id, 'Pomyślnie zaaktualizowałeś projekt.', 'success');
                unset($_SESSION['posted']);
            // TODO ATTACHMENTS
        }
        return $rows;
    }
}