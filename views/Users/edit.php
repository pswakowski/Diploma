<h1 class="h2">Edytuj użytkownika</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="panel panel-dafult">
    <div class="panel-body">
        <form method="POST">
            <div class="form-group col-4">
                <label>Email: </label>
                <input type="text" name="email" class="form-control" value="<?php echo $viewModel['users']['email']; ?>" required/>
                <label>Imię: </label>
                <input type="text" name="name" class="form-control" value="<?php echo $viewModel['users']['name']; ?>" required/>
                <label>Nazwisko: </label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $viewModel['users']['lastname']; ?>" required/>
                <label>Rola użytkownika: </label>
                <select class="form-custom-select" name="roles_id" required>
                    <?php foreach($viewModel['all_roles'] as $item) : ?>
                        <?php if ($item['id'] == $viewModel['roles']['id']) : ?>
                            <option value="<?php echo $viewModel['roles']['id'] ?>" selected><?php echo $viewModel['roles']['name'] ?></option>
                        <?php else : ?>
                            <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <br>
                <input class="btn btn-primary" name="submit" type="submit" value="Zaaktualizuj">
                <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/users">Powrót</a>
            </div>
        </form>
    </div>
</div>