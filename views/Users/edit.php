<h1 class="h2">Edytuj użytkownika</h1>
<hr>
<?php Messages::display(); ?>
<pre>
    <?php print_r($viewModel);
    ?>
</pre>
<div class="panel panel-dafult">
    <div class="panel-body">
        <form method="POST">
            <div class="form-group col-4">
                <label>Email: </label>
                <input type="text" name="email" class="form-control" value="<?php echo $viewModel['users']['email']; ?>"/>
                <label>Imię: </label>
                <input type="text" name="name" class="form-control" value="<?php echo $viewModel['users']['name']; ?>" />
                <label>Nazwisko: </label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $viewModel['users']['lastname']; ?>" />
                <label>Hasło: </label>
                <input type="text" name="password" class="form-control" value="<?php echo $viewModel['users']['password']; ?>" />
                <label>Rola użytkownika: </label>
                <select class="form-custom-select" name="roles_id">
                    <?php foreach($viewModel['roles'] as $item) : ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <input class="btn btn-primary" name="submit" type="submit" value="Zaaktualizuj">
                <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/users">Powrót</a>
            </div>
        </form>
    </div>
</div>