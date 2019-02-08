<h1 class="h2">Pokaż projekt</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="row" method="post">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa projektu</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" name="name" value="<?php echo $viewModel['projects']['name']; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść projektu</label>
            <textarea rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder="" name="description" disabled><?php echo $viewModel['projects']['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label class="my-1 mr-2" for="formGroupExampleInput2">Deadline</label>
            <input class="form-control" style="max-width: 260px; display: inline-block;" type="text" name="deadline" value="<?php echo $viewModel['projects']['end_date']; ?>" disabled>
        </div>
        <a class="btn btn-primary" href="<?php echo ROOT_URL; ?>/projects">Powrót</a>
        <?php if ($_SESSION['user_data']['role'] != '2' && $viewModel['projects']['status'] == '1') : ?>
            <a class="btn btn-warning" href="<?php ROOT_URL ?>/projects/edit/<?php echo $viewModel['projects']['id'] ?>">Edytuj projekt</a>
            <a class="btn btn-danger" href="<?php ROOT_URL ?>/projects/finish/<?php echo $viewModel['projects']['id'] ?>">Zakończ projekt</a>
        <?php endif; ?>
    </div>
    <div class="col-sm-5">

        <h5>Załączniki:</h5>
        <br>
        <?php foreach($viewModel['attachments'] as $item) : ?>
            <a href="<?php ROOT_URL ?>/assets/attachments/<?php echo $item['name'] ?>" download><span data-feather="download"></span> <?php echo $item['title'] ?></a> (<?php echo $item['version']; ?>)<br>
        <?php endforeach; ?>
    </div>
</div>