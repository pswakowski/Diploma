<?php

class Tasks extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new TasksModel();
        $this->returnView($viewModel->index(), true);

    }

    protected function add()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new TasksModel();
        $this->returnView($viewModel->add(), true);
    }

    protected function show()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new TasksModel();
        $this->returnView($viewModel->show(), true);
    }

    protected function edit()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new TasksModel();
        $this->returnView($viewModel->edit(), true);
    }

}