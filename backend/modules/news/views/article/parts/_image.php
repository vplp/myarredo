<?php

/**
 * @var \backend\app\bootstrap\ActiveForm $form
 * @var \backend\modules\news\models\Article $model
 */

echo $form->field($model, 'image_link')->imageOne($model->getArticleImage());
