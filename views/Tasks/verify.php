<?php if ($_SESSION['user_data']['role'] != '2') : ?>
    <h1 class="h2">Wszystkie zadania do weryfikacji</h1>
<?php else : ?>
    <h1 class="h2">Moje zadania do weryfikacji</h1>
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
                    <th scope="row"><?php echo $item['id']; ?></th>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['verify_name'] . ' ' . $item['verify_lastname']; ?></td>
                    <td><?php echo $item['projects_name']; ?></td>
                    <td><?php echo $item['end_date']  ?></td>
                    <td><?php echo $item['users_name'] . ' ' . $item['users_lastname']; ?></td>
                    <td>
                        <a href="show/<?php echo $item['id']; ?>" class="btn btn-dark">Zobacz</a>
                        <form method="post" action="rollback" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                            <input type="hidden" name="u" value="<?php echo $item['verify_id'] ?>">
                            <input type="submit" class="btn btn-warning" value="Przywróć">
                        </form>
                        <form method="post" action="end" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                            <input type="hidden" name="u" value="<?php echo $item['verify_id'] ?>">
                            <input type="submit" class="btn btn-success" value="Zakończ">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <?php foreach($viewModel['users'] as $item) : ?>
                <tr class="table">
                    <th scope="row"><?php echo $item['id']; ?></th>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $_SESSION['user_data']['name'] . ' ' . $_SESSION['user_data']['lastname']; ?></td>
                    <td><?php echo $item['projects_name']; ?></td>
                    <td><?php echo $item['end_date']; ?></td>
                    <td><?php echo $item['users_name'] . ' ' . $item['users_lastname']; ?></td>
                    <td>
                        <a href="show/<?php echo $item['id']  ?>" class="btn btn-dark">Zobacz</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
</div>