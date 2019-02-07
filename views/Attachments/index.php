<h1 class="h2">Dokumenty</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa pliku</th>
            <th scope="col">Dodany przez</th>
            <th scope="col">Wersja</th>
            <th scope="col">Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($viewModel as $item) : ?>
            <tr class="table">
                <th scope="row"><?php echo $item['id'];  ?></th>
                <td><?php echo $item['title']; ?></td>
                <td><?php echo $item['name'] . ' ' . $item['lastname'];  ?></td>
                <td><?php echo $item['version'];  ?></td>
                <td>
                    <a href="<?php echo ROOT_URL; ?>/attachments/delete/<?php echo $item['id'];  ?>" class="btn btn-danger">Usuń</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($_SESSION['user_data']['role'] != '2') : ?>
        <form class="card" method="POST" ENCTYPE="multipart/form-data">
            <div class="card-body">
                <input type="file" value="file" name="file">
                <input type="submit" class="btn btn-primary" name="upload" value="Dodaj dokument">
            </div>
        </form>
    <?php endif; ?>
</div>