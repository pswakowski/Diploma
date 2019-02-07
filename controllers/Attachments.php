<?php

class Attachments extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['is_logged']))
        {
            Helpers::redirect('/home/login', 'Nie jesteś zalogowany.' , 'error');
        }
        if ($_SESSION['user_data']['role'] == '2')
        {
            Helpers::redirect('/', 'Nie masz odpowiedniego dostępu!', 'error');
        }

        $viewModel = new AttachmentsModel();
        $this->returnView($viewModel->index(), true);
    }
}