<?php

class UserModel extends Model
{
    public function index()
    {
        $this->query('SELECT * FROM users');
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
            if($post['email'] == '' || $post['name'] == '' || $post['lastname'] == '' || $post['password'] == 'roles_id')
            {
                Messages::setMessage('Błąd! Nie uzupełniłes wszystkich danych!', 'error');
                return;
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
                header('Location: '. ROOT_URL . '/users');
            }
            return;
        }

        return $rows;
    }

    public function edit()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            $this->query("SELECT roles.id, roles.name, users.roles_id FROM roles INNER JOIN users ON users.roles_id = roles.id where users.id = {$_SESSION['user_data']['id']}");
            $rows['roles'] = $this->resultSet();

            $this->query("SELECT * FROM users where id = $id");
            $rows2['users'] = $this->single();

            $data = array_merge($rows, $rows2);
        }


        return $data;
    }
}