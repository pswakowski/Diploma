<h1 class="h2">Dodaj nowego użytkownika</h1>
<hr>
<?php Messages::display(); ?>
<div class="panel panel-dafult">
    <div class="panel-body">
        <form method="POST">
            <div class="form-group col-4">
                <label>Email: </label>
                <input type="text" name="email" class="form-control" />
                <label>Imię: </label>
                <input type="text" name="name" class="form-control" />
                <label>Nazwisko: </label>
                <input type="text" name="lastname" class="form-control" />
                <label>Hasło: </label>
                <input type="text" name="password" class="form-control" />
                <label>Rola użytkownika: </label>
                <select class="form-custom-select" name="roles_id">
                    <?php foreach($viewModel as $item) : ?>
                    <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <input class="btn btn-primary" name="submit" type="submit" value="Dodaj użytkownika">
                <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/users">Powrót</a>
            </div>
        </form>
    </div>
</div>