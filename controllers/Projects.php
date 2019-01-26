<?php

class Projects extends Controller
{

    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->index(), true);

    }

    protected function add()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->add(), true);
    }


    protected function show()
    {

        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->show(), true);
    }

    protected function edit()
    {

        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }

        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->edit(), true);
    }
}