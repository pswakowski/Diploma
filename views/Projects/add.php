<h1 class="h2">Utwórz nowy projekt</h1>
<hr>
<?php if (Messages::display() != null){
    header('Location:' . ROOT_URL . '/projects/add');
} ?>
<?php print_r($viewModel); ?>
<form class="row" method="post">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa projektu</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" name="name" value="<?php echo $_POST['name']; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść projektu</label>
            <textarea rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder="" name="description"><?php echo $_POST['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label class="my-1 mr-2" for="formGroupExampleInput2">Data:</label>
            <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="date" name="deadline" value="<?php echo $_POST['deadline']; ?>">
            <br><label class="my-1 mr-2" for="formGroupExampleInput2">Godzina:</label>
            <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="time" name="deadlinetime" value="<?php echo $_POST['deadlinetime']; ?>">
        </div>

        <input type="submit" class="btn btn-primary" name="submit" value="Stwórz projekt">
        <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/projects">Powrót</a>
    </div>
    <div class="col-sm-5">

        <h5>Załączniki:</h5>
        <select style="max-width: 400px;" class="custom-select" size="6" name="attachment[]" multiple>
            <option selected>Wybierz plik</option>
            <option value="1">dokumentacja.docx</option>
            <option value="2">dokumentacja2.docx</option>
            <option value="3">dokumentacja3.docx</option>
            <option value="4">dokumentacja3.docx</option>
            <option value="5">dokumentacja3.docx</option>
        </select>
    </div>
</form>