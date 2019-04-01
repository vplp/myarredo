<?php

/**
 * @var \frontend\modules\catalog\models\ItalianProduct $model
 * @var \frontend\modules\catalog\models\ItalianProductLang $modelLang
 * @var \frontend\modules\catalog\models\Specification $Specification
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
    echo $this->render('../sale-italy/view', [
        'model' => $model,
        'modelLang' => $modelLang
    ]);
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
