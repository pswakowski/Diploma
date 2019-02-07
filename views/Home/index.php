<h1 class="h2">Aktualności</h1>
<hr>
<?php Helpers::displayMessage(); ?>
<div class="table-responsive">
    <form method="post">
        <h5>Dodaj nowy wpis <input type="submit" name="send" style="padding: 2px 8px 0 7px;" class="btn btn-primary" value="Wyślij&rarr;"></h5>
        <textarea rows="4" class="form-control" name="input-sm" placeholder="Co słychać?"></textarea>
    </form>

    <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Ostatnie wpisy</h6>
        <?php foreach ($viewModel as $item) : ?>
        <div class="media text-muted pt-3">
            <img alt="" class="mr-2 rounded">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark"><?php echo $item['name'] . ' ' . $item['lastname']; ?> <small><?php echo $item['post_date']; ?></small></strong>
                <?php echo $item['text']; ?>
            </p>
        </div>
        <?php endforeach; ?>
        <?php if ($_SESSION['user_data']['role'] == '1') : ?>
        <small class="d-block text-right mt-3">
            <a href="<?php echo ROOT_URL; ?>/social">Wszystkie aktualizacje</a>
        </small>
        <?php endif; ?>
    </div>
</div>