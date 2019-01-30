<h1 class="h2">Zadania</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Projekt</th>
            <th scope="col">Początek</th>
            <th scope="col">Deadline</th>
            <th scope="col">Opiekun</th>
            <th scope="col">Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($viewModel as $item) : ?>
            <tr class="table" <?php echo Helpers::task_is_past($item['end_date']); ?>>
                <th scope="row"><?php echo $item['id']  ?></th>
                <td><?php echo $item['name'] ?></td>
                <td><?php echo $item['projects_name']  ?></td>
                <td><?php echo $item['start_date']  ?></td>
                <td><?php echo $item['end_date']  ?></td>
                <td><?php echo $item['users_name'] . ' ' . $item['users_lastname']  ?></td>
                <td><a href="tasks/show/<?php echo $item['id']  ?>" class="btn btn-dark">Zobacz</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="card">
        <div class="card-body">
            <a href="tasks/add" class="btn btn-primary">Dodaj Zadanie</a>
        </div>
    </div>
</div>