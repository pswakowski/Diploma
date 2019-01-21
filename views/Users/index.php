    <h1 class="h2">Użytkownicy</h1>
    <hr>
    <?php Messages::display(); ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Imię</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Ostatnie logowanie</th>
                <th scope="col">Utworzono</th>
                <th scope="col">Rola</th>
                <th scope="col">Akcje</th>
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
                <td><?php echo $item['create_date']  ?></td>
                <td><?php echo $item['roles_id']  ?></td>
                <td><a href="users/edit/<?php echo $item['id']  ?>" class="btn btn-dark">Edytuj</a> <a href="users/delete/<?php echo $item['id']  ?>" class="btn btn-danger">Usuń</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="card">
            <div class="card-body">
                <a href="users/add" class="btn btn-primary">Dodaj użytkownika</a>
            </div>
        </div>
    </div>