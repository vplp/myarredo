<?php


?>

    <div class="w" style="min-height: 1000px"><!---->
        <h1 style="font-size: 40px"> Search: <?= $condition ?></h1>


        <div class="row">

            <?php if ($posts): ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="col-md-12">
                        <a href="<?= $post->getUrl() ?>"> <?= $post['lang']['title'] ?> </a>
                    </div>

                <?php endforeach; ?>

            <?php else : ?>
                <h1> Not found </h1>
            <?php endif; ?>

        </div>
    </div>

<?php




