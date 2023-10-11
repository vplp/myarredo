<?php

use yii\helpers\Html;

/**
 * @var $model \frontend\modules\news\models\ArticleForPartners
 */

$this->title = $model['lang']['title'];

?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', Html::encode($model['lang']['title']), []); ?>
                <div class="text">

                    <?= $model['lang']['content'] ?>

                </div>
            </div>

        </div>
    </div>
</main>