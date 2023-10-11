<?php

use yii\helpers\Html;

/**
 * @var \common\modules\forms\models\FormsFeedback $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', Html::encode($this->context->title), []); ?>
                <div class="text">

                    <?= $this->render('parts/form', [
                        'model' => $model
                    ]) ?>

                </div>
            </div>

        </div>
    </div>
</main>
