<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\widgets\partner\PartnerMap;

$this->title = $this->context->title;
?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>

                <div class="map-cont">

                    <?= PartnerMap::widget([]) ?>

                    <?= Html::a(
                        Yii::t('app','Вернуться назад'),
                        Url::toRoute('/page/contacts/index'),
                        ['class' => 'view-all']
                    ); ?>

                </div>
            </div>

        </div>
    </div>
</main>
