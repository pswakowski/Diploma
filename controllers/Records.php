<?php

class Records extends Controller
{
    protected function Index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }

        if ($_SESSION['user_data']['role'] != '1')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }
        
        $viewModel = new RecordsModel();
        $this->returnView($viewModel->index(), true);
    }
}