<?php

class Projects extends Controller
{

    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }
        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->index(), true);

    }

    protected function add()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->add(), true);
    }


    protected function show()
    {

        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }
        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->show(), true);
    }

    protected function edit()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->edit(), true);
    }

    protected function finish()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $id = $_GET['id'];
        $model = new ProjectsModel();
        $model->query("UPDATE projects set status = '0' where id = :id");
        $model->bind(":id", $id);

        $model->execute();
        Helpers::redirect('/projects/finished', 'Zakończyłeś projekt o ID: ' . $id . '.', 'success');
    }

    protected function rollback()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $id = $_GET['id'];
        $model = new ProjectsModel();
        $model->query("UPDATE projects set status = '1' where id = :id");
        $model->bind(":id", $id);

        $model->execute();
        Helpers::redirect('/projects', 'Przywróciłeś projekt o ID: ' . $id . '.', 'success');
    }

    protected function finished()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $viewModel = new ProjectsModel();
        $this->returnView($viewModel->finished(), true);
    }
}