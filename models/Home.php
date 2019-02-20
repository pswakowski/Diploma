<?php

class HomeModel extends Model
{
    public function index()
    {
        $this->query('SELECT users.name, users.lastname, social_media.text, social_media.post_date FROM users INNER JOIN social_media ON users.id = social_media.users_id order by social_media.post_date desc limit 10');
        $rows['social'] = $this->resultSet();

        $this->query("SELECT projects.name, projects.end_date, projects.color, 
	    sum(case when users_has_tasks.status = '0' then 1 else 0 end) finished,
        sum(case when projects.status = '1' then 1 else 0 end) result
        FROM tasks right JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id 
        	right JOIN users u1 ON u1.id = users_has_tasks.users_id 
                right JOIN projects ON tasks.projects_id = projects.id 
                 JOIN users u2 ON projects.author_id = u2.id 
                 	where projects.status = '1' and projects.id > 1
                	group by projects.name order by projects.id asc");
        $rows2['projects'] = $this->resultSet();

        $this->query('SELECT id, email, name, lastname, last_login from users where id = :id');
        $this->bind(':id', $_SESSION['user_data']['id']);
        $rows3['users'] = $this->resultSet();

        $this->query("SELECT sum(case when users_has_tasks.status = '0' then 1 else 0 end) finished,
        sum(case when users_has_tasks.status >= '0' then 1 else 0 end) alls,
        sum(case when users_has_tasks.status = '2' then 1 else 0 end) verify
	    FROM tasks JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id 
	    JOIN users u1 ON u1.id = users_has_tasks.users_id where u1.id = :id");
        $this->bind(":id", $_SESSION['user_data']['id']);
        $rows4['tasks_done'] = $this->single();
        
        $data = array_merge($rows, $rows2, $rows3, $rows4);

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($post['send'])
        {
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
        return $data;
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