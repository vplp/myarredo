<?php
//use yii\helpers\ArrayHelper;
//use backend\modules\news\models\Group;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @var \backend\modules\news\models\Article $model
 * @var \backend\modules\news\models\ArticleLang $modelLang
 * @var \backend\themes\inspinia\widgets\forms\ActiveForm $form
 */
?>
<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'alias')->textInput(['mexlength' => true]) ?>
<?= $form->field($model, 'group_id')->hiddenInput(['value'=> 1])->label(false) ?>
<?php /*$form->field($model, 'group_id')->dropDownList(ArrayHelper::merge(
    [0 => '---' . Yii::t('app', 'Choose group') . '---'],
    Group::getDropdownList()
));*/ ?>
<?= $form->field($model, 'image_link')->imageOne($model->getArticleImage()) ?>
<?= $form->field($model, 'gallery_link')->imageSeveral([
    'minFileCount' => 1,
    'maxFileCount' => 10,
    'initialPreview' => $model->getArticleGallery(),
]) ?>

<?= $form->field($modelLang, 'description')->editor() ?>
<?= $form->field($modelLang, 'content')->editor() ?>

<?= $form->field($model, 'published')->checkbox();
