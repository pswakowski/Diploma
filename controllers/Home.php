<?php

class Home extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', $_SESSION['message'] , 'error');
        }
        $viewModel = new HomeModel();
        $this->returnView($viewModel->index(), true);

    }

    protected function login()
    {
        // tutaj zawsze musi byc instankcja obiektu modelu dla TEGO Kontrolera
        $viewModel = new HomeModel();
        $this->returnView($viewModel->login(), false);
    }

}