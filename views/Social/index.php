<h1 class="h2">Social media</h1>
<hr>
<?php Helpers::displayMessage();
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Imię</th>
            <th scope="col">Nazwisko</th>
            <th style="width: 900px;" scope="col">Treść</th>
            <th scope="col">Data dodania</th>
            <th scope="col">Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($viewModel as $item) : ?>
            <tr class="table">
                <th scope="row"><?php echo $item['id']  ?></th>
                <td><?php echo $item['name']  ?></td>
                <td><?php echo $item['lastname']  ?></td>
                <td><?php echo $item['text']  ?></td>
                <td><?php echo $item['post_date']  ?></td>
                <td>
                    <a href="social/delete/<?php echo $item['id']  ?>" class="btn btn-danger">Usuń</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>