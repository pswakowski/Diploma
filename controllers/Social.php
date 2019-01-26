<?php

class Social extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']) OR $_SESSION['user_data']['role'] != 1)
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new SocialModel();
        $this->returnView($viewModel->index(), true);
    }

    protected function delete()
    {
        if (!isset($_SESSION['is_logged']) OR $_SESSION['user_data']['role'] != 1)
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $id = $_GET['id'];
        $model = new UserModel();
        $model->query("DELETE FROM social_media WHERE id = $id");
        $model->execute();
        Helpers::redirect('/social', 'Usunąłeś wpis społecznościowy o ID: ' . $id . '.', 'success');
    }

}