<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $country \frontend\modules\location\models\Country
 * @var $city \frontend\modules\location\models\City
 */

?>

<div class="partner-cities container large-container">
    <div class="row">
        <div>
            <?= Yii::t('app', 'Этот список городов размещен здесь для вашего удобства. Найдите свой город и купите итальянскую мебель по лучшей цене.') ?>
        </div>
        <ul>

            <?php foreach ($country['cities'] as $cityCountry): ?>

                <?= Html::beginTag('li') ?>
                <?= Html::a($cityCountry['lang']['title'], $cityCountry->getSubDomainUrl()) ?>
                <?= Html::endTag('li') ?>

            <?php endforeach; ?>

        </ul>
    </div>
</div>