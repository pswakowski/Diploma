<?php

class Records extends Controller
{
    protected function Index()
    {
        if (!isset($_SESSION['is_logged']) OR $_SESSION['user_data']['role'] != 1) {
            header('Location:' . ROOT_URL . '/home/login');
        }
        $viewModel = new RecordsModel();
        $this->returnView($viewModel->index(), true);
    }
}