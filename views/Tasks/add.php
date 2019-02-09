<h1 class="h2">Utwórz nowe zadanie</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<form class="row" method="post">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa zadania</label>
            <input name="name" type="text" class="form-control" id="formGroupExampleInput" placeholder="Nazwa zadania..." required>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść zadania</label>
            <textarea name="description" rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Treść zadania..." required></textarea>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="my-1 mr-2" for="formGroupExampleInput2">Data:</label>
                    <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="date" name="deadline" required>
                    <br><label class="my-1 mr-2" for="formGroupExampleInput2">Godzina:</label>
                    <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="time" name="deadlinetime" required>
                </div>
                <div class="form-group">
                    <label class="my-1 mr-2" for="formGroupExampleInput2">Projekt</label>
                    <select name="project_id" class="custom-select my-1 mr-sm-4" id="inlineFormCustomSelectPref" required>
                        <option selected>Wybierz...</option>
                        <?php foreach($viewModel['projects'] as $item) : ?>
                        <?php  if(empty($item)) continue;  ?>
                        <option value="<?php echo $item['project_id'] ?>"><?php echo $item['project_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <label class="my-1 mr-2" for="formGroupExampleInput2">Dołącz załącznik:</label>
                <select name="attachment[]" class="custom-select" size="4" multiple>
                    <?php foreach($viewModel['attachments'] as $item) : ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Dodaj zadanie">
        <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/tasks">Powrót</a>
    </div>

    <div class="col-sm-5">
        <h5>Użytkownicy:</h5>
        <hr>
        <h6>Administracja</h6>
        <?php foreach($viewModel['admins'] as $item) : ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="users_id[]" value="<?php echo $item['admin_id'] ?>">
            <label class="form-check-label" for="exampleRadios1">
                <?php echo $item['admin_name'] . ' ' . $item['admin_lastname'] ?>
            </label>
        </div>
        <?php endforeach; ?>
        <br>
        <h6>Pracownicy</h6>
        <?php foreach($viewModel['users'] as $item) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="users_id[]" value="<?php echo $item['user_id'] ?>">
                <label class="form-check-label" for="exampleRadios1">
                    <?php echo $item['user_name'] . ' ' . $item['user_lastname'] ?>
                </label>
            </div>
        <?php endforeach; ?>
        <hr>
    </div>
</form>