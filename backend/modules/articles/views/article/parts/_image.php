<?php

/**
 * @var \backend\app\bootstrap\ActiveForm $form
 * @var \backend\modules\articles\models\Article $model
 */

echo $form->field($model, 'image_link')->imageOne($model->getArticleImage());
