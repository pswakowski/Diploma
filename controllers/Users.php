<?php

class Users extends Controller
{
    protected function Index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] != '1')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new UserModel();
        $this->returnView($viewModel->index(), true);
    }
    
    protected function add()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] != '1')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new UserModel();
        $this->returnView($viewModel->add(), true);
    }

    protected function edit()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] != '1')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new UserModel();
        $this->returnView($viewModel->edit(), true);
    }


    protected function logout()
    {
        // kill all session variables
        unset($_SESSION['is_logged']);
        unset($_SESSION['user_data']);
        session_destroy();

        //redirect
        header('Location:' . ROOT_URL . '/home/login');
    }

    protected function inactive()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] != '1')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $id = $_GET['id'];
        $model = new UserModel();
        $model->query("UPDATE users set status = '0' where id = :id");
        $model->bind(":id", $id);
        $model->execute();
        Helpers::redirect('/users', 'Zmieniłeś status użytkownika o ID: ' . $id . ' na nieaktywny.', 'success');
    }

    protected function active()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] != '1')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $id = $_GET['id'];
        $model = new UserModel();
        $model->query("UPDATE users set status = '1' where id = :id");
        $model->bind(":id", $id);
        $model->execute();
        Helpers::redirect('/users', 'Zmieniłeś status użytkownika o ID: ' . $id . ' na aktywny.', 'success');
    }
}