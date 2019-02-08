<?php

class AttachmentsModel extends Model
{
    public function index()
    {
        $this->query("SELECT attachments.id, attachments.title, attachments.version, users.name, users.lastname FROM attachments 
	join users on attachments.sender = users.id where attachments.status = 1");
        $rows = $this->resultSet();

        if(isset($_POST['upload']))
        {
            $max_size = 1000000;
            $upload = $_SERVER['DOCUMENT_ROOT'] . "/assets/attachments/";
            $time = date("d-m-Y-His");

            if (is_uploaded_file($_FILES['file']['tmp_name']))
            {
                if ($_FILES['file']['size'] > $max_size)
                {
                    Helpers::redirect("/attachments", "Przekroczenie rozmiaru $max_size bajtów", 'error');
                }
                else
                {
                    $filename = $time . '_' . $_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $upload . $filename);

                    //$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $this->query("INSERT INTO attachments (title, name, sender, version, status) values (:title, :name, :sender, current_timestamp, 1)");

                    $this->bind(":title", $_FILES['file']['name']);
                    $this->bind(":name", $filename);
                    $this->bind(":sender", $_SESSION['user_data']['id']);

                    $this->execute();

                    if ($this->lastInsertId())
                    {
                        Helpers::redirect("/attachments", "Odebrano plik: {$_FILES['file']['name']}", 'success');
                    }
                }
            }
            else
            {
                Helpers::redirect("/attachments", "Błąd przy przesyłaniu danych!", 'error');
            }
        }

        return $rows;
    }
}