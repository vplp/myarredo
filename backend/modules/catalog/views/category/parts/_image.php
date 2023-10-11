<?php

/**
 * @var \backend\modules\catalog\models\Category $model
 * @var \backend\modules\catalog\models\CategoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink('image_link'))
    . $form->field($model, 'image_link2')->imageOne($model->getImageLink('image_link2'))
    . $form->field($model, 'image_link3')->imageOne($model->getImageLink('image_link3'))
    . $form->field($model, 'image_link_com')->imageOne($model->getImageLink('image_link_com'))
    . $form->field($model, 'image_link2_com')->imageOne($model->getImageLink('image_link2_com'))
    . $form->field($model, 'image_link_de')->imageOne($model->getImageLink('image_link_de'))
    . $form->field($model, 'image_link2_de')->imageOne($model->getImageLink('image_link2_de'))
    . $form->field($model, 'image_link_fr')->imageOne($model->getImageLink('image_link_fr'))
    . $form->field($model, 'image_link2_fr')->imageOne($model->getImageLink('image_link2_fr'));
