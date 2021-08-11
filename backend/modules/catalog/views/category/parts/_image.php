<?php

/**
 * @var \backend\modules\catalog\models\Category $model
 * @var \backend\modules\catalog\models\CategoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink())
    . $form->field($model, 'image_link2')->imageOne($model->getImageLink2())
    . $form->field($model, 'image_link3')->imageOne($model->getImageLink3())
    . $form->field($model, 'image_link_com')->imageOne($model->getImageLinkCom())
    . $form->field($model, 'image_link2_com')->imageOne($model->getImageLink2Com())
    . $form->field($model, 'image_link_home')->imageOne($model->getImageLinkHome());
