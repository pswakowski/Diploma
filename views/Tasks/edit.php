<h1 class="h2">Edytuj zadanie</h1>
<hr>
<form class="row" method="post">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa zadania</label>
            <input name="name" type="text" class="form-control" id="formGroupExampleInput" placeholder="" value="<?php echo $viewModel['tasks']['name']; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść zadania</label>
            <textarea name="description" rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder=""><?php echo $viewModel['tasks']['description']; ?></textarea>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="my-1 mr-2" for="formGroupExampleInput2">Data:</label>
                    <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="date" name="deadline" value="<?php echo substr($viewModel['tasks']['end_date'], 0, -9); ?>">
                    <br><label class="my-1 mr-2" for="formGroupExampleInput2">Godzina:</label>
                    <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="time" name="deadlinetime" value="<?php echo substr($viewModel['tasks']['end_date'], 11); ?>">
                </div>
                <div class="form-group">
                    <label class="my-1 mr-2" for="formGroupExampleInput2">Projekt</label>
                    <select name="project_id" class="custom-select my-1 mr-sm-4" id="inlineFormCustomSelectPref">
                    <?php foreach($viewModel['all_projects'] as $item) : ?>
                        <?php if ($item['id'] == $viewModel['projects']['id']) : ?>
                            <option value="<?php echo $viewModel['projects']['id']; ?>" selected>
                                <?php echo $viewModel['projects']['name']; ?>
                            </option>
                        <?php else : ?>
                            <option value="<?php echo $item['id']; ?>">
                                <?php echo $item['name']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <label class="my-1 mr-2" for="formGroupExampleInput2">Załączniki</label>
                <select name="attachment" class="custom-select" size="4" multiple>
                    <option selected>Wybierz plik</option>
                    <option value="1">dokumentacja.docx</option>
                    <option value="2">dokumentacja2.docx</option>
                    <option value="3">dokumentacja3.docx</option>
                    <option value="4">dokumentacja3.docx</option>
                    <option value="5">dokumentacja3.docx</option>
                </select>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Edytuj zadanie">
        <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/tasks">Powrót</a>
    </div>

    <div class="col-sm-5">
        <h5>Użytkownicy:</h5>
        <hr>
        <h6>Administracja</h6>

        <?php foreach($viewModel['all_admins'] as $item) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="users_id[]" id="exampleRadios1" value="<?php echo $item['id']; ?>"
                    <?php if(Helpers::in_array_r($item['id'], $viewModel['admins'])) : ?>
                        checked
                    <?php endif; ?>>
                <label class="form-check-label" for="exampleRadios1">
                    <?php echo $item['name'] . ' ' . $item['lastname'] ?>
                </label>
            </div>
        <?php endforeach; ?>
        <br>
        <h6>Pracownicy</h6>
        <?php foreach($viewModel['all_users'] as $item) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="users_id[]" id="exampleRadios1" value="<?php echo $item['id']; ?>"
                    <?php if(Helpers::in_array_r($item['id'], $viewModel['users'])) : ?>
                        checked
                    <?php endif; ?>>
                <label class="form-check-label" for="exampleRadios1">
                    <?php echo $item['name'] . ' ' . $item['lastname'] ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</form>
<pre>
    <?php //print_r($viewModel) ?>
</pre>