<?php
$_SESSION['TINYMCE_filemanager_ALLOW'] = true;
?>
<?= $form->text_line_lang($modelLang, 'description')->textarea([
    'style' => 'height:100px;'
]) ?>
<?= $form->text_editor_lang($modelLang, 'content') ?>
