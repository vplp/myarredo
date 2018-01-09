<?php

use yii\helpers\{
    Url, Html
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
                <div class="of-conts">

                    <?php foreach ($partners as $partner): ?>
                        <div class="one-cont">
                            <?= Html::tag('h4', $partner->profile->name_company); ?>
                            <div class="adres">
                                <?= $partner->profile->address ?>
                            </div>
                            <a href="tel:<?= $partner->profile->phone ?>"><?= $partner->profile->phone ?></a>
                        </div>
                    <?php endforeach; ?>


                </div>
                <div class="warning">
                    * Обращаем ваше внимание, цены партнеров сети могут отличаться.
                </div>
                <div class="map-cont">

                    <?= PartnerMap::widget(['city' => Yii::$app->city->getCity()]) ?>

                    <?= Html::a(
                        'Посмотреть все офисы продаж',
                        Url::toRoute('/page/contacts/list-partners'),
                        ['class' => 'view-all']
                    ); ?>

                </div>
            </div>

        </div>
    </div>
</main>