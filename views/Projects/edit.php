<h1 class="h2">Edytuj projekt</h1>
<hr>
<form class="row" method="post">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa projektu</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" name="name" value="<?php echo $viewModel['projects']['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść projektu</label>
            <textarea rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder="" name="description" required><?php echo $viewModel['projects']['description']; ?></textarea>
        </div>
        <div class="form-group">
            <h6>Deadline:</h6>
            <label class="my-1 mr-2" for="formGroupExampleInput2">Data</label>
            <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="date" name="deadline" value="<?php echo substr($viewModel['projects']['end_date'], 0, -9); ?>" required>
            <br><label class="my-1 mr-2" for="formGroupExampleInput2">Godzina</label>
            <input id="deadline" class="form-control" style="max-width: 260px; display: inline-block;" type="time" name="deadlinetime" value="<?php echo substr($viewModel['projects']['end_date'], 11); ?>" required>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Edytuj projekt">
        <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>/projects">Powrót</a>
    </div>
    <div class="col-sm-5">

        <h5>Załączniki:</h5>
        <select style="max-width: 400px;" class="custom-select" size="6" name="attachment[]" multiple>
            <?php foreach($viewModel['all_attachments'] as $item) : ?>
                <?php if(Helpers::in_array_r($item['id'], $viewModel['attachments'])) : ?>
                    <option value="<?php echo $item['id'] ?>" selected><?php echo $item['title'] ?></option>
                <?php else : ?>
                    <option value="<?php echo $item['id'] ?>"><?php echo $item['title'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</form>