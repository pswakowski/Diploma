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

        $this->query('SELECT id, email, name, lastname, last_login, last_logout from users where id = :id');
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
            $this->query("INSERT INTO social_media (text, post_date, users_id) VALUES (:text, current_timestamp, :user)");

            $this->bind(':text', $post['input-sm']);
            $this->bind(':user', $_SESSION['user_data']['id']);

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
            $this->query("SELECT * FROM users where email = :email AND status = '1'");

            $this->bind(':email', $post['email']);
            //$this->bind(':password', $password);

            $row = $this->single();
            $status = $row['attempt'];
            if (!$row)
            {
                Helpers::redirect(ROOT_PATH, 'Nie ma w systemie takiego pracownika.', 'error');
            }
            else
            {
                if (substr($status, 0, 2) == "b-")
                {
                    $blockedTime = substr($status, 2);
                    if (time() < $blockedTime)
                    {
                        $block = true;
                    } else
                    {
                        $this->query("UPDATE users SET attempt = '' WHERE email = :email");
                        $this->bind(':email', $post['email']);
                        $this->single();
                    }
                }

                if ($block == true)
                {
                    Helpers::redirect('/home/login', 'Zostaniesz odblokowany o: <br>' . date("Y-m-d H:i:s", $blockedTime), 'error');
                }

                if (!isset($block))
                {
                    if ($row['password'] == $password)
                    {
                        $_SESSION['is_logged'] = true;
                        $_SESSION['user_data'] = array(
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "lastname" => $row['lastname'],
                            "role" => $row['roles_id'],
                        );

                        $date = new DateTime($row['last_login']);
                        $date_now = new DateTime();
                        $interval = $date->diff($date_now);

                        if ($interval->days != 0)
                        {
                            $this->query("UPDATE users SET last_login = CURRENT_TIMESTAMP where email = :email");
                            $this->bind(':email', $post['email']);
                            $this->single();
                        }

                        Helpers::redirect(ROOT_PATH, 'Zalogowałeś się poprawnie.', 'success');
                    } else
                    {
                        if ($status == "")
                        {
                            // User was not logged in before
                            $this->query("UPDATE users set attempt='1' WHERE email = :email");
                            $this->bind(':email', $post['email']);
                            $this->single();
                            Helpers::redirect(ROOT_PATH, 'To Twoja 1 zła próba logowania. Po 3 złej zostaniesz zablokowany.', 'error');
                        } else if ($status == 3)
                        {
                            $this->query("UPDATE users SET attempt = :attempt WHERE email = :email");
                            $this->bind(":attempt", "b-" . strtotime("+15 minutes", time()));
                            $this->bind(':email', $post['email']);
                            $this->single();
                            Helpers::redirect(ROOT_PATH, 'Twoje konto zostało zablokowane na 15 minut.', 'error');
                        } else if ($status <= 3)
                        {
                            $status++;
                            $this->query("UPDATE users SET attempt = :attempt WHERE email = :email");
                            $this->bind(':attempt', $status);
                            $this->bind(':email', $post['email']);
                            $this->single();
                            Helpers::redirect(ROOT_PATH, "To Twoja $status zła próba logowania. Po 3 złej zostaniesz zablokowany", 'error');
                        }
                    }
                }
            }
        }
        return;
    }
}