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


    protected function show($id = 1)
    {

        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->show($id), true);
    }

}