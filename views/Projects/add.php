<h1 class="h2">Utwórz nowy projekt</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<form class="row" method="post">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa projektu</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" name="name" value="<?php echo $_SESSION['posted'][0]; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść projektu</label>
            <textarea rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder="" name="description"><?php echo $_SESSION['posted'][1]; ?></textarea>
        </div>
        <div class="form-group">
            <label class="my-1 mr-2" for="formGroupExampleInput2">Data:</label>
            <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="date" name="deadline" value="<?php echo $_SESSION['posted'][2];; ?>">
            <br><label class="my-1 mr-2" for="formGroupExampleInput2">Godzina:</label>
            <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="time" name="deadlinetime" value="<?php echo $_SESSION['posted'][3];; ?>">
        </div>

        <input type="submit" class="btn btn-primary" name="submit" value="Stwórz projekt">
        <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/projects">Powrót</a>
    </div>
    <div class="col-sm-5">

        <h5>Załączniki:</h5>
        <select style="max-width: 400px;" name="attachment[]" class="custom-select" size="4" multiple>
            <?php foreach($viewModel['attachments'] as $item) : ?>
                <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>