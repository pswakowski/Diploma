<h1 class="h2">Projekty zakończone</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Deadline</th>
            <th scope="col">Opiekun</th>
            <th scope="col">Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($viewModel as $item) : ?>
            <tr class="table">
                <th scope="row"><?php echo $item['projects_id'];  ?></th>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['end_date'];  ?></td>
                <td><?php echo $item['user_name'] . ' ' . $item['user_lastname'];  ?></td>
                <td>
                    <a href="<?php echo ROOT_URL; ?>/projects/show/<?php echo $item['projects_id'];  ?>" class="btn btn-dark">Zobacz</a>
                    <?php if ($_SESSION['user_data']['role'] != '2') : ?>
                    <a href="<?php echo ROOT_URL; ?>/projects/rollback/<?php echo $item['projects_id']  ?>" class="btn btn-success">Przywróć</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>