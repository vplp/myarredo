<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 */

echo $this->render('../../sale-italy/view', [
    'model' => $model,
    'modelLang' => $modelLang
]);

?>


<div class="buttons-cont">
    <?= Html::a(
        Yii::t('app', 'Edit'),
        ['/catalog/italian-product/update', 'id' => $model->id],
        ['class' => 'btn btn-primary']
    ) ?>

    <?= Html::a(
        Yii::t('app', 'Опубликовать'),
        ['/catalog/italian-product/update', 'id' => $model->id, 'step' => 'payment'],
        ['class' => 'btn btn-primary']
    ) ?>
</div>
