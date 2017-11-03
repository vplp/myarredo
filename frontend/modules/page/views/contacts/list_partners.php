<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\widgets\partner\PartnerMap;

?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>

                <div class="map-cont">

                    <?= PartnerMap::widget([]) ?>

                    <?= Html::a(
                        'Вернуться назад',
                        Url::toRoute('/page/contacts/index'),
                        ['class' => 'view-all']
                    ); ?>

                </div>
            </div>

        </div>
    </div>
</main>
