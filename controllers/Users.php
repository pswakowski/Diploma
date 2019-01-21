<?php

class Users extends Controller
{
    protected function Index()
    {
        if (!isset($_SESSION['is_logged']) OR $_SESSION['user_data']['role'] != 1)
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new UserModel();
        $this->returnView($viewModel->index(), true);
    }
    
    protected function add()
    {
        if (!isset($_SESSION['is_logged']) OR $_SESSION['user_data']['role'] != 1)
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new UserModel();
        $this->returnView($viewModel->add(), true);
    }

    protected function edit()
    {
        if (!isset($_SESSION['is_logged']) OR $_SESSION['user_data']['role'] != 1)
        {
            header('Location:' . ROOT_URL . '/home/login');
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
}