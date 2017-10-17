<?php

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?php //$form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>

<?= $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>
