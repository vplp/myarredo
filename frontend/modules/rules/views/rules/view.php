<?php

use yii\helpers\Html;
//
use frontend\modules\rules\models\Rules;
use frontend\modules\forms\widgets\FormFeedback;

/** @var Rules $model */

$this->title = $model['lang']['title'];
?>

<main>
    <div class="page about-page rules-page">
        <div class="largex-container">
            <div class="rulesbox">
                <?= Html::tag('h2', $model['lang']['title'], []); ?>

                <div class="rulescont">

                    <?= $model['lang']['content'] ?>

                </div>
                <div class="rulespanel">
                    <?= FormFeedback::widget(['view' => 'form_feedback_rules']) ?>
                </div>
            </div>

        </div>
    </div>
</main>
