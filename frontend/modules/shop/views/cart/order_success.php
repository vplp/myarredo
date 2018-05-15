<?php

use yii\helpers\{
    Html, Url
};

$this->title = $this->context->title;

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>
                </div>

                <div class="col-md-12">
                    <p><?= Yii::t('app','Благодарим за обращение, Ваша заявка отправлена.') ?></p>
                </div>

            </div>
        </div>
    </div>
</main>
