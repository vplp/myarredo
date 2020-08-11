<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\user\widgets\partner\PartnerMap;
use frontend\modules\user\models\User;

$this->title = $this->context->title;

/** @var $partners User[] */
/** @var $partner User */

?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>
                <div class="of-conts">

                    <?php foreach ($partners as $partner) { ?>
                        <div class="one-cont">
                            <?= Html::tag('h4', $partner->profile->getNameCompany()); ?>
                            <div class="adres">
                                <?= isset($partner->profile->city) ? $partner->profile->city->getTitle() . '<br>' : '' ?>
                                <?= $partner->profile->lang->address ?? '' ?>
                            </div>
                            <?= Html::a(
                                $partner->profile->getPhone(),
                                'tel:' . $partner->profile->getPhone()
                            ) ?>
                        </div>
                    <?php } ?>

                </div>
                <div class="warning">
                    * <?= Yii::t('app', 'Обращаем ваше внимание, цены партнеров сети могут отличаться.') ?>
                </div>
                <div class="map-cont">

                    <?= PartnerMap::widget(['city' => Yii::$app->city->getCity()]) ?>

                    <?= Html::a(
                        Yii::t('app', 'Посмотреть все офисы продаж'),
                        Url::toRoute('/page/contacts/list-partners'),
                        ['class' => 'view-all']
                    ); ?>

                </div>
            </div>
        </div>
    </div>
</main>
