<?php

class Calendar extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new CalendarModel();
        $this->returnView($viewModel->index(), true);

    }

}