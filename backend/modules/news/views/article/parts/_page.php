<?= $form->field($modelLang, 'content', [
    'template' => '<div class="input-group">{label}<span class="input-group-addon">' . Yii::$app->language . '</span></div>{input}{error}{hint}'
])->editor() ?>
