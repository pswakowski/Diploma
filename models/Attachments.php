<?php

class AttachmentsModel extends Model
{
    public function index()
    {
        $this->query("SELECT attachments.id, attachments.title, attachments.version, users.name, users.lastname FROM attachments 
	join users on attachments.sender = users.id");
        $rows = $this->resultSet();

        if(isset($_POST['upload']))
        {
            $max_size = 1000000;
            $upload = $_SERVER['DOCUMENT_ROOT'] . "/assets/attachments/";

            if (is_uploaded_file($_FILES['file']['tmp_name']))
            {
                if ($_FILES['file']['size'] > $max_size)
                {
                    Helpers::redirect("/attachments", "Przekroczenie rozmiaru $max_size bajtów", 'error');
                }
                else
                {
                    move_uploaded_file($_FILES['file']['tmp_name'], $upload . $_FILES['file']['name']);

                    //$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $this->query("INSERT INTO attachments (title, sender, version) values (:title, :sender, current_timestamp)");

                    $this->bind(":title", $_FILES['file']['name']);
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