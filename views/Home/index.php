
<h1 class="h2">Aktualności</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="row">
    <div class="col-sm-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projekty</h6>
            </div>
            <div class="card-body">
                <?php foreach($viewModel['projects'] as $item) : ?>
                <h4 class="small font-weight-bold"><?php echo $item['name']?> <span class="float-right"><?php echo @Helpers::progress($item['finished'], $item['result']); ?></span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar <?php echo $item['color']; ?>" role="progressbar" style="width: <?php echo @Helpers::progress($item['finished'], $item['result']); ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div>
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dzisiejszy czas pracy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo Helpers::get_working_time($viewModel['users'][0]['last_login']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% wykonanych zadań</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo @Helpers::progress($viewModel['tasks_done']['finished'], $viewModel['tasks_done']['alls']); ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo @Helpers::progress($viewModel['tasks_done']['finished'], $viewModel['tasks_done']['alls']); ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div>
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><a href="/tasks">Zadania do wykonania</a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $viewModel['tasks_done']['alls'] - $viewModel['tasks_done']['finished']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="/tasks/verify">Zadania czekające na weryfikację</a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $viewModel['tasks_done']['verify'] > 0 ? $viewModel['tasks_done']['verify'] : "0"; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="table-responsive">
    <form method="post">
        <h5>Dodaj nowy wpis <input type="submit" name="send" style="padding: 2px 8px 0 7px;" class="btn btn-primary" value="Wyślij&rarr;"></h5>
        <textarea rows="4" class="form-control" name="input-sm" placeholder="Co słychać?" required></textarea>
    </form>

    <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Ostatnie wpisy</h6>
        <?php foreach ($viewModel['social'] as $item) : ?>
        <div class="media text-muted pt-3">
            <img alt="" class="mr-2 rounded">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark"><?php echo $item['name'] . ' ' . $item['lastname']; ?> <small><?php echo $item['post_date']; ?></small></strong>
                <?php echo $item['text']; ?>
            </p>
        </div>
        <?php endforeach; ?>
        <?php if ($_SESSION['user_data']['role'] == '1') : ?>
        <small class="d-block text-right mt-3">
            <a href="<?php echo ROOT_URL; ?>/social">Wszystkie aktualizacje</a>
        </small>
        <?php endif; ?>
    </div>
</div>