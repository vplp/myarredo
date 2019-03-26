<?php


?>

    <div class="w" style="min-height: 1000px"><!---->
        <h1 style="font-size: 40px"> Search: <?= $condition ?></h1>


        <div class="row">

            <?php if ($posts) {
                foreach ($posts as $post) { ?>
                    <div class="col-md-12">
                        <?= Html::a(
                            $post['lang']['title'],
                            $post->getUrl(),
                            []
                        ) ?>
                    </div>
                <?php }
            } else { ?>
                <h1>Not found</h1>
            <?php } ?>

        </div>
    </div>

<?php




