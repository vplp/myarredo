<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $model Sale
 * @var $modelLang SaleLang
 */

$this->title = ($model->isNewRecord)
    ? Yii::t('app', 'Add')
    : Yii::t('app', 'Edit');

?>

<main>
    <div class="page create-sale">
        <div class="largex-container itprodform-box">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">

                <?php
                if (Yii::$app->request->get('step') == 'photo') {
                    echo $this->render('parts/_step2', [
                        'model' => $model,
                        'modelLang' => $modelLang
                    ]);
                } elseif (Yii::$app->request->get('step') == 'check') {
                    echo $this->render('parts/_step3', [
                        'model' => $model,
                        'modelLang' => $modelLang
                    ]);
                } else {
                    echo $this->render('parts/_step1', [
                        'model' => $model,
                        'modelLang' => $modelLang
                    ]);
                } ?>

            </div>
        </div>
    </div>
</main>