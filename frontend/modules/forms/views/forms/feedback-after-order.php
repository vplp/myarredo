<?php

use yii\helpers\Html;

/**
 * @var \common\modules\forms\models\FormsFeedback $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', Html::encode($this->context->title), []); ?>
                <div class="text">

                    <?= $this->render('parts/form-feedback-after-order', [
                        'model' => $model,
                        'partners' => $partners
                    ]) ?>

                </div>
            </div>

        </div>
    </div>
</main>
