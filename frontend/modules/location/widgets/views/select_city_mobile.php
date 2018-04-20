<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $country \frontend\modules\location\models\Country
 * @var $city \frontend\modules\location\models\City
 */

?>

<ul class="mobile-city-list js-list-container">
    <?php foreach ($country['cities'] as $cityCountry):
        $option = ($cityCountry['id'] == $city['id']) ? ['class'=>'active'] : [];
        ?>

        <?= Html::beginTag('li', $option) ?>
        <?= Html::a($cityCountry['lang']['title'], $cityCountry->getSubDomainUrl()) ?>
        <?= Html::endTag('li') ?>

    <?php endforeach; ?>
</ul>