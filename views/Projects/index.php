<h1 class="h2">Projekty</h1>
<hr>
<?php Helpers::displayMessage();
$array = Array();
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Deadline</th>
            <th scope="col">Opiekun</th>
            <th scope="col">Postęp</th>
            <th scope="col">Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($viewModel['projects'] as $item) : ?>
            <tr class="table" data-toggle="tooltip" title="Przypisani użytkownicy: <?php foreach ($viewModel['users'] as $users)
            {
                if ($item['projects_id'] == $users['id'])
                {
                    echo "\n" . $users['name'] . ' ' . $users['lastname'];
                }
            }
            ?>" <?php echo Helpers::project_is_past($item['end_date']); ?>>
                <th scope="row"><?php echo $item['projects_id'];  ?></th>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['end_date'];  ?></td>
                <td><?php echo $item['user_name'] . ' ' . $item['user_lastname'];  ?></td>
                <td><?php echo @Helpers::progress($item['finished'], $item['result']); ?></td>
                <td>
                    <a href="<?php echo ROOT_URL; ?>/projects/show/<?php echo $item['projects_id'];  ?>" class="btn btn-dark">Zobacz</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($_SESSION['user_data']['role'] != '2') : ?>
    <div class="card">
        <div class="card-body">
            <a href="projects/add" class="btn btn-primary">Dodaj projekt</a>
        </div>
    </div>
    <?php endif; ?>
</div>