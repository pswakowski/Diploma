<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Aktualności</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/calendar.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body>

<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>UTP / Firma</h3>
        </div>

        <ul class="list-unstyled components">
            <p>Panel główny</p>
            <li <?php if ($_SERVER['REQUEST_URI'] == '/') echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/"><span data-feather="home"></span> Aktualności</a>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/tasks')) echo 'class="active"'; ?>>
                <a href="#tasksSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span data-feather="list"></span> Zadania
                </a>
                <ul class="collapse list-unstyled" id="tasksSubmenu">
                    <li>
                        <a href="<?php echo ROOT_URL; ?>/tasks">Trwające</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL; ?>/tasks/verify">Do weryfikacji</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL; ?>/tasks/finished">Zakończone</a>
                    </li>
                    <?php if ($_SESSION['user_data']['role'] != '2') : ?>
                        <li>
                            <a href="<?php echo ROOT_URL; ?>/tasks/all">Wszystkie</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/projects')) echo 'class="active"'; ?>>
                <a href="#projectsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span data-feather="package"></span> Projekty
                </a>
                <ul class="collapse list-unstyled" id="projectsSubmenu">
                    <li>
                        <a href="<?php echo ROOT_URL; ?>/projects">Trwające</a>
                    </li>
                    <li>
                        <a href="<?php echo ROOT_URL; ?>/projects/finished">Zakończone</a>
                    </li>
                </ul>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/calendar')) echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/calendar"><span data-feather="calendar"></span> Kalendarz</a>
            </li>
        </ul>
        <?php if ($_SESSION['user_data']['role'] == '1') : ?>
        <ul class="list-unstyled components">
            <p>Administracja</p>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/users')) echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/users"><span data-feather="users"></span> Użytkownicy</a>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/records')) echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/records"><span data-feather="watch"></span> Ewidencja czasu pracy</a>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/social')) echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/social"><span data-feather="message-circle"></span> Social media</a>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/documents')) echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/documents"><span data-feather="layers"></span> Dokumenty</a>
            </li>
            <li <?php if (strstr($_SERVER['REQUEST_URI'], '/settings')) echo 'class="active"'; ?>>
                <a href="<?php echo ROOT_URL; ?>/settings"><span data-feather="settings"></span> Ustawienia</a>
            </li>
        </ul>
        <?php endif; ?>


    </nav>

    <!-- Page Content Holder -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <span class="nav-link">Witaj <?php echo $_SESSION['user_data']['name']; ?>!</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link logout-link" href="<?php echo ROOT_URL; ?>/users/logout">Wyloguj</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php require ($view); ?>

        
        <footer>
            <hr>
            &copy; Przemysław Swakowski 2019
        </footer>
        <br>
    </div>
</div>

<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
</script>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
</body>
</html>