<?php

use yii\helpers\Html;

$this->title = $name;
?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?php Html::tag('h1', Html::encode($this->title), []); ?>
                <div class="text">

                    <p><?= nl2br(Html::encode($message)) ?></p>

                </div>
            </div>

        </div>
    </div>
</main>
