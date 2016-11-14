<?php
use thread\app\bootstrap\ActiveForm;

$form = ActiveForm::begin();
echo $form->submit($model, $this);
echo $form->text_line($model, 'alias');
echo $form->text_line($model, 'local');
echo $form->text_line($model, 'label');
echo $form->field($model, 'img_flag')->imageOne($model->getImage());
echo $form->checkbox($model, 'default');
echo $form->switcher($model, 'published');
echo $form->submit($model, $this);
ActiveForm::end();
