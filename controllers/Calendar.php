<?php

class Calendar extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }
        $viewModel = new CalendarModel();
        $this->returnView($viewModel->index(), true);

    }

}