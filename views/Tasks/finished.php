<?php if ($_SESSION['user_data']['role'] != '2') : ?>
    <h1 class="h2">Wszystkie zakończone zadania</h1>
<?php else : ?>
    <h1 class="h2">Moje zakończone zadania</h1>
<?php endif; ?>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Wykonawca</th>
            <th scope="col">Projekt</th>
            <th scope="col">Deadline</th>
            <th scope="col">Opiekun</th>
            <th scope="col">Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($_SESSION['user_data']['role'] != '2') : ?>
            <?php foreach($viewModel['admins'] as $item) : ?>
                <tr class="table">
                    <th scope="row"><?php echo $item['id']  ?></th>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['verify_name'] . ' ' . $item['verify_lastname']  ?></td>
                    <td><?php echo $item['projects_name']  ?></td>
                    <td><?php echo $item['end_date']  ?></td>
                    <td><?php echo $item['users_name'] . ' ' . $item['users_lastname']  ?></td>
                    <td>
                        <a href="show/<?php echo $item['id']  ?>" class="btn btn-dark">Zobacz</a>
                        <a href="rollback/<?php echo $item['id']  ?>" class="btn btn-warning">Przywróć</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <?php foreach($viewModel['users'] as $item) : ?>
                <tr class="table">
                    <th scope="row"><?php echo $item['id']  ?></th>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['projects_name']  ?></td>
                    <td><?php echo $item['start_date']  ?></td>
                    <td><?php echo $item['end_date']  ?></td>
                    <td><?php echo $item['users_name'] . ' ' . $item['users_lastname']  ?></td>
                    <td>
                        <a href="show/<?php echo $item['id']  ?>" class="btn btn-dark">Zobacz</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
</div>