<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>
<?= $form1->field($model, 'gallery_image')->imageSeveral([
    'minFileCount' => 1,
    'maxFileCount' => 10,
    'initialPreview' => $model->getGalleryImage(),
]) ?>
<?= $form->switcher($model, 'published') ?>