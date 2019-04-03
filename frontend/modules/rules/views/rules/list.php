<?php

use yii\helpers\Html;
//
use frontend\modules\rules\models\Rules;

$this->title = $this->context->title;

/** @var Rules[] $models */
/** @var Rules $model */

?>
    <main>
        <div class="page about-page">
            <div class="container large-container">
                <div class="col-md-12">
                    <?= Html::tag('h1', Yii::t('app', 'General rules'), []); ?>
                    <div class="text">

                        <?php
                        echo Html::beginTag('ul');

                        foreach ($models as $model) {
                            echo Html::beginTag('li');
                            echo Html::a($model->getTitle(), $model->getUrl());
                            echo Html::endTag('li');
                        }

                        echo Html::endTag('ul');
                        ?>

                    </div>
                </div>

            </div>
        </div>
    </main>
<?php
