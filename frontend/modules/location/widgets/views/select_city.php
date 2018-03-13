<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $country \frontend\modules\location\models\Country
 * @var $city \frontend\modules\location\models\City
 */

?>

<div class="city-select-cont">
    <div class="container large-container">
        <div class="row">
            <div class="top-panel">
                <div class="top-panel-in">
                    <a href="javascript:void(0);" class="set-country"><?= $country['lang']['title'] ?></a>
                    <a href="javascript:void(0);" id="close-top">
                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="title-city"><?= Yii::t('app', 'Your city') ?></div>
                <div class="tab-country-content">
                    <ul class="links-cont">

                        <?php foreach ($country['cities'] as $cityCountry):
                            $option = ($cityCountry['id'] == $city['id']) ? ['class'=>'active'] : [];
                            ?>

                            <?= Html::beginTag('li', $option) ?>
                                <?= Html::a($cityCountry['lang']['title'], $cityCountry->getSubDomainUrl()) ?>
                            <?= Html::endTag('li') ?>

                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>