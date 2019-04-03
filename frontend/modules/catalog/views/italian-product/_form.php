<?php

use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 */

$this->title = (($model->isNewRecord)
        ? Yii::t('app', 'Add')
        : Yii::t('app', 'Edit')) .
    ' ' . Yii::t('app', 'Furniture in Italy');

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
} elseif (Yii::$app->request->get('step') == 'payment') {
    echo $this->render('parts/_step4', [
        'model' => $model,
        'modelLang' => $modelLang
    ]);
} else {
    echo $this->render('parts/_step1', [
        'model' => $model,
        'modelLang' => $modelLang
    ]);
}
