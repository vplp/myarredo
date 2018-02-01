<?php

use yii\helpers\{
    Html, Url
};

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>
                </div>

                <div class="col-md-12">
                    <p><?= $message ?></p>
                    <p>Благодарим за обращение, Ваша заявка отправлена.</p>
                </div>

            </div>
        </div>
    </div>
</main>
