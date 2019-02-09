<?php

class UserModel extends Model
{
    public function index()
    {
        $this->query('SELECT users.id, users.status, users.email, users.name, users.lastname, users.create_date, roles.name as role_name FROM users inner join roles on roles.id = users.roles_id');
        $rows = $this->resultSet();

        return $rows;
    }

    public function add()
    {
        $this->query('SELECT * FROM roles');
        $rows = $this->resultSet();

        // Sanitizing POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password = md5($post['password']);

        if($post['submit'])
        {
            if($post['roles_id'] == '')
            {
                Helpers::redirect('/users/add', 'Błąd! Nie uzupełniłeś wszystkich danych!', 'error');
                return 0;
            }
            // Insert into DB
            $this->query("INSERT INTO users (email, name, lastname, password, status, create_date, roles_id) 
                          VALUES (:email, :name, :lastname, :password, '1', current_timestamp, :roles_id)");

            $this->bind(':email', $post['email']);
            $this->bind(':name', $post['name']);
            $this->bind(':lastname', $post['lastname']);
            $this->bind(':password', $password);
            $this->bind(':roles_id', $post['roles_id']);

            $this->execute();

            // verify
            if ($this->lastInsertId())
            {
                Helpers::redirect('/users', 'Dodałeś nowego użytkownika', 'success');
            }
        }

        return $rows;
    }

    public function edit()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            $this->query("SELECT roles.id, roles.name, users.roles_id FROM roles INNER JOIN users ON users.roles_id = roles.id where users.id = $id");
            $rows['roles'] = $this->single();

            $this->query("SELECT roles.id, roles.name FROM roles");
            $rows2['all_roles'] = $this->resultSet();

            $this->query("SELECT * FROM users where id = $id");
            $rows3['users'] = $this->single();

            $data = array_merge($rows, $rows2, $rows3);
        }

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($post['submit'])
        {
            if($post['email'] == '' || $post['name'] == '' || $post['lastname'] == '')
            {
                Helpers::redirect('/users/edit/' . $id, 'Błąd! Nie uzupełniłeś wszystkich danych!', 'error');
            }
            // Insert into DB
            $this->query("UPDATE users set email = :email, name = :name, lastname = :lastname, roles_id = :roles_id where id = :id");

            $this->bind(':email', $post['email']);
            $this->bind(':name', $post['name']);
            $this->bind(':lastname', $post['lastname']);
            $this->bind(':roles_id', $post['roles_id']);
            $this->bind(':id', $id);

            $this->execute();

            // redirect
            Helpers::redirect('/users', 'Zaktualizowałeś dane użytkownika o ID: ' . $id . '.', 'success');
        }
        return $data;
    }
}