<?php

class ProjectsModel extends Model
{
    public function index()
    {
        $this->query("SELECT projects.id as projects_id, projects.name, projects.end_date, projects.author_id, u2.id as user_id, u2.name as user_name, u2.lastname as user_lastname, 
	sum(case when users_has_tasks.status = '0' then 1 else 0 end) finished,
        sum(case when projects.status = '1' then 1 else 0 end) result
	FROM tasks right JOIN users_has_tasks ON tasks.id = users_has_tasks.tasks_id 
        	right JOIN users u1 ON u1.id = users_has_tasks.users_id 
                right JOIN projects ON tasks.projects_id = projects.id 
                 JOIN users u2 ON projects.author_id = u2.id 
                 	where projects.status = '1' and projects.id > 1
                	group by projects.name order by projects.id asc");

        $rows['projects'] = $this->resultSet();

        $this->query("SELECT DISTINCT users.name, users.lastname, projects.id FROM users_has_tasks 
	join tasks on users_has_tasks.tasks_id = tasks.id
        join users on users_has_tasks.users_id = users.id 
        join projects on tasks.projects_id = projects.id
        where users.name = ALL (select name from users where id < 0)");

        $rows2['users'] = $this->resultSet();

        $data = array_merge($rows, $rows2);

        return $data;
    }

    public function add ()
    {
        $this->query('SELECT * FROM attachments');
        $rows = $this->resultSet();

        $this->query('SELECT attachments.id, attachments.title from attachments where attachments.status = 1');
        $rows2['attachments'] = $this->resultSet();

        // Sanitizing POST

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $color = Array("bg-danger", "bg-warning", "bg-info", "bg-success", "");
        $color_index = array_rand($color, 1);


        $data = array_merge($rows, $rows2);

        if($post['submit'])
        {
            $deadline = $post['deadline']. ' ' .$post['deadlinetime'];

            // Insert into DB
            $this->query("INSERT INTO projects (name, description, start_date, end_date, author_id, status, color) 
                          VALUES (:name, :description, current_timestamp, :end_date, :user, '1', :color)");

            $this->bind(':name', $post['name']);
            $this->bind(':description', $post['description']);
            $this->bind(':end_date', $deadline);
            $this->bind(':color', $color[$color_index]);
            $this->bind(':user', $_SESSION['user_data']['id']);

            $this->execute();

            // verify

            $project_id = $this->lastInsertId();

            $attachments_array = $_POST['attachment'];
            if(isset($attachments_array))
            {
                for ($i = 0; $i < count($attachments_array); $i++) {
                    $attachment = $attachments_array[$i];
                    $this->query("INSERT IGNORE INTO projects_has_attachment (projects_id, attachments_id) VALUES (:projects_id, :attachments_id)");
                    $this->bind(':projects_id', $project_id);
                    $this->bind(':attachments_id', $attachment);
                    $this->execute();
                }
            }

            Helpers::redirect('/projects', 'Utworzyłeś nowy projekt o ID: ' . $project_id .'.', 'success');
        }
        return $data;
    }

    public function show()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            $this->query("SELECT * FROM projects where id = :id");
            $this->bind(":id", $id);
            $rows['projects'] = $this->single();

            $this->query("select attachments.id, attachments.title, attachments.name, attachments.version, projects_has_attachment.projects_id from projects_has_attachment inner join attachments on attachments.id = projects_has_attachment.attachments_id where projects_id = :id and attachments.status = 1");
            $this->bind(":id", $id);
            $rows2['attachments'] = $this->resultSet();

            $data = array_merge($rows, $rows2);

            return $data;
        }

    }

    public function edit()
    {
        $id = $_GET['id'];

        if (isset($id) && $id != '')
        {
            $this->query("SELECT * FROM projects where id = :id");
            $this->bind(":id", $id);
            $rows['projects'] = $this->single();

            $this->query("select attachments.id, attachments.title from projects_has_attachment inner join attachments on attachments.id = projects_has_attachment.attachments_id where projects_id = :id and attachments.status = 1");
            $this->bind(":id", $id);
            $rows2['attachments'] = $this->resultSet();

            $this->query('SELECT attachments.id, attachments.title from attachments where attachments.status = 1');
            $rows3['all_attachments'] = $this->resultSet();
        }

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = array_merge($rows, $rows2, $rows3);

        if($post['submit'])
        {
            $deadline = $post['deadline']. ' ' .$post['deadlinetime'];

            // Insert into DB
            $this->query("UPDATE projects set name = :name, description = :description, end_date = :end_date where id = :id");
            $this->bind(":id", $id);
            $this->bind(':name', $post['name']);
            $this->bind(':description', $post['description']);
            $this->bind(':end_date', $deadline);

            $this->execute();

            $attachments_array = $_POST['attachment'];

            if(isset($attachments_array))
            {
                for ($i = 0; $i < count($attachments_array); $i++) {
                    $attachment = $attachments_array[$i];
                    $this->query("INSERT IGNORE INTO projects_has_attachment (projects_id, attachments_id) VALUES (:projects_id, :attachments_id)");
                    $this->bind(':projects_id', $id);
                    $this->bind(':attachments_id', $attachment);
                    $this->execute();
                }
            }

            Helpers::redirect('/projects/show/' . $id, 'Pomyślnie zaaktualizowałeś projekt.', 'success');
        }
        return $data;
    }

    public function finished()
    {
        $this->query("SELECT projects.id as projects_id, projects.name, projects.end_date, projects.author_id, users.id as user_id, users.name as user_name, users.lastname as user_lastname FROM projects INNER JOIN users ON projects.author_id = users.id WHERE projects.status = '0'");
        $rows = $this->resultSet();
        return $rows;
    }
}