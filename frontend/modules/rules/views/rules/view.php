<?php

use yii\helpers\Html;
//
use frontend\modules\rules\models\Rules;

/** @var Rules $model */

$this->title = $model['lang']['title'];
?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h2', $model['lang']['title'], []); ?>
                <div class="text">

                    <?= $model['lang']['content'] ?>

                </div>
            </div>

        </div>
    </div>
</main>
