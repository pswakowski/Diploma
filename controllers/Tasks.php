<?php

class Tasks extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $viewModel = new TasksModel();
        $this->returnView($viewModel->index(), true);
    }

    protected function add()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $viewModel = new TasksModel();
        $this->returnView($viewModel->add(), true);
    }

    protected function show()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $viewModel = new TasksModel();
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

        $viewModel = new TasksModel();
        $this->returnView($viewModel->edit(), true);
    }

    protected function finish()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $id = $_GET['id'];
        $model = new TasksModel();
        $model->query("UPDATE users_has_tasks set status = '2' where tasks_id = :id and users_id = :users_id");
        $model->bind(":id", $id);
        $model->bind(":users_id", $_SESSION['user_data']['id']);

        $model->execute();
        Helpers::redirect('/tasks/verify', 'Wysłałeś zadanie o ID: ' . $id . ' do weryfikacji.', 'success');
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
        $pieces = explode("0", $id);
        $task = $pieces[0];
        $user = $pieces[1];

        $model = new TasksModel();
        $model->query("UPDATE users_has_tasks set status = '1' where tasks_id = :tasks_id and users_id = :users_id");
        $model->bind(":tasks_id", $task);
        $model->bind(":users_id", $user);

        $model->execute();
        Helpers::redirect('/tasks', 'Przywróciłeś zadanie o ID: ' . $task . '.', 'success');
    }

    protected function end()
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
        $pieces = explode("0", $id);
        $task = $pieces[0];
        $user = $pieces[1];

        $model = new TasksModel();
        $model->query("UPDATE users_has_tasks set status = '0' where tasks_id = :tasks_id and users_id = :users_id");
        $model->bind(":tasks_id", $task);
        $model->bind(":users_id", $user);

        $model->execute();
        Helpers::redirect('/tasks/finished', 'Zakończyłeś definitywnie zadanie o ID: ' . $task . '.', 'success');
    }

    protected function finished()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $viewModel = new TasksModel();
        $this->returnView($viewModel->finished(), true);
    }

    protected function verify()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        $viewModel = new TasksModel();
        $this->returnView($viewModel->verify(), true);
    }

    protected function all()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }
        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new TasksModel();
        $this->returnView($viewModel->all(), true);
    }
}