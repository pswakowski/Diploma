<h1 class="h2">Ewidencja czasu pracy</h1>
<hr>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Email</th>
            <th scope="col">Imię</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">Zalogowany</th>
            <th scope="col">Ostatnie wylogowanie</th>
            <th scope="col">Czas pracy</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($viewModel as $item) : ?>
            <tr class="table">
                <th scope="row"><?php echo $item['id']  ?></th>
                <td><?php echo $item['email'] ?></td>
                <td><?php echo $item['name']  ?></td>
                <td><?php echo $item['lastname']  ?></td>
                <td><?php echo $item['last_login']  ?></td>
                <td><?php echo $item['last_logout']  ?></td>
                <td><?php echo Helpers::get_working_time($item['last_login'], $item['last_logout']);  ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>