<?php

class HomeModel extends Model
{
    public function index()
    {
        $this->query('SELECT users.name, users.lastname, social_media.text, social_media.post_date FROM users INNER JOIN social_media ON users.id = social_media.users_id order by social_media.post_date desc limit 10');
        $rows = $this->resultSet();

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($post['send'])
        {
            if ($post['input-sm'] == '')
            {
                Helpers::redirect('/', 'Nie możesz dodać pustego wpisu!', 'error');
            }

            // Insert into DB
            $this->query("INSERT INTO social_media (text, post_date, users_id) VALUES (:text, current_timestamp, {$_SESSION['user_data']['id']})");

            $this->bind(':text', $post['input-sm']);

            $this->execute();

            // verify
            if ($this->lastInsertId())
            {
                Helpers::redirect('/', 'Dodałes nowy wpis społecznościowy!', 'success');
            }
        }
        return $rows;
    }

    public function login()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password = md5($post['password']);

        if($post['submit'])
        {
            // Insert into DB
            $this->query("SELECT * FROM users where email = :email AND password = :password AND status = '1'");

            $this->bind(':email', $post['email']);
            $this->bind(':password', $password);

            $row = $this->single();

            if ($row)
            {
                $_SESSION['is_logged'] = true;
                $_SESSION['user_data'] = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "lastname" => $row['lastname'],
                    "role" => $row['roles_id'],
                );

                if (date("H:i:s") > "08:00:00" && date("H:i:s") < "18:00:00")
                {
                    $time = date("Y-m-d H:i:s");
                    $this->query("UPDATE users SET last_login = :time where email = :email");
                    $this->bind(':email', $post['email']);
                    $this->bind(':time', $time);
                    $this->single();
                }
                if (date("H:i:s") > "07:00:00" && date("H:i:s") < "08:00:00")
                {
                    $time = date("Y-m-d") . " 08:00:00";
                    $this->query("UPDATE users SET last_login = :time where email = :email");
                    $this->bind(':email', $post['email']);
                    $this->bind(':time', $time);
                    $this->single();
                }
                Helpers::redirect(ROOT_PATH, 'Zalogowałeś się poprawnie.', 'success');
            }
            else
            {
                Helpers::redirect('/home/login', 'Niepoprawne dane logowania', 'error');
            }
        }
        return;
    }
}