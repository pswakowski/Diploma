<?php

class Home extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
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