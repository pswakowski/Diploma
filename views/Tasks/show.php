<h1 class="h2">Podgląd zadania</h1>
<hr>

<?php
function in_array_r($item , $array)
{
    return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
}
?>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="formGroupExampleInput">Nazwa zadania</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" value="<?php echo $viewModel['tasks']['name']; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Treść zadania</label>
            <textarea rows="8" type="text" class="form-control" id="formGroupExampleInput2" placeholder="" disabled><?php echo $viewModel['tasks']['description']; ?></textarea>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="my-1 mr-2" for="formGroupExampleInput2">Deadline</label>
                    <input class="form-control" type="text" name="week" disabled value="<?php echo $viewModel['tasks']['end_date']; ?>">
                </div>
                <div class="form-group">
                    <label class="my-1 mr-2" for="formGroupExampleInput2">Projekt</label>
                    <select class="custom-select my-1 mr-sm-4" id="inlineFormCustomSelectPref" disabled>
                        <option selected><?php echo $viewModel['projects']['name']; ?></option>
                    </select>
                </div>
            </div>
            <div class="col">
                <label class="my-1 mr-2" for="formGroupExampleInput2">Załączniki</label>
                <select class="custom-select" size="4" multiple disabled>
                    <option>Wybierz plik</option>
                    <option value="1">dokumentacja.docx</option>
                    <option value="1" selected>dokumentacja2.docx</option>
                    <option value="1">dokumentacja3.docx</option>
                    <option value="1">dokumentacja3.docx</option>
                    <option value="1">dokumentacja3.docx</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <h5>Przypisani użytkownicy:</h5>
        <hr>
        <h6>Administracja</h6>

        <?php foreach($viewModel['all_admins'] as $item) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="admin_id[]" id="exampleRadios1" value="<?php echo $item['id']; ?>"
                        <?php if(in_array_r($item['name'], $viewModel['admins'])) : ?>
                            checked
                    <?php endif; ?> disabled>
                    <label class="form-check-label" for="exampleRadios1">
                        <?php echo $item['name'] . ' ' . $item['lastname'] ?>
                    </label>
                </div>
        <?php endforeach; ?>
        <br>
        <h6>Pracownicy</h6>
        <?php foreach($viewModel['all_users'] as $item) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="admin_id[]" id="exampleRadios1" value="<?php echo $item['id']; ?>"
                    <?php if(in_array_r($item['name'], $viewModel['users'])) : ?>
                        checked
                    <?php endif; ?> disabled>
                <label class="form-check-label" for="exampleRadios1">
                    <?php echo $item['name'] . ' ' . $item['lastname'] ?>
                </label>
            </div>
        <?php endforeach; ?>
        <hr>
        <a class="btn btn-warning" href="<?php ROOT_URL ?>/tasks/edit/<?php echo $viewModel['tasks']['id'] ?>">Edytuj zadanie</a>
        <br><br>
        <input class="btn btn-danger" name="endtask" type="submit" value="Zakończ zadanie">
    </div>
</div>
<div class="row">
    <div class="col">
        <h5>Komentarze</h5>
        <hr>
        <?php foreach($viewModel['notes'] as $item) : ?>
        <div class="media">
            <div class="media-body">
                <h6 class="mt-0">Przez: <?php echo $item['name'] . ' ' . $item['lastname']; ?></h6>
                <small><?php echo $item['date'] ?></small>
                <p><?php echo $item['note'] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col">
        <h5>Dodaj komentarz</h5>
        <hr>
        <form method="post">
            <div class="form-group">
                <textarea rows="4" type="text" class="form-control" id="test" placeholder="Treść komentarza" name="note"></textarea>
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Dodaj komentarz">
        </form>
    </div>
</div>