<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $country \frontend\modules\location\models\Country
 * @var $city \frontend\modules\location\models\City
 */

?>

<ul class="links-cont js-list-container">
    <?php
    foreach ($country['cities'] as $cityCountry) {
        $option = ($cityCountry['id'] == $city['id']) ? ['class' => 'active'] : [];

        echo Html::beginTag('li', $option);
        echo Html::a(
            $cityCountry['lang']['title'],
            $cityCountry->getSubDomainUrl() . '/' . Yii::$app->request->pathInfo,
            ['rel' => 'nofollow']
        );
        echo Html::endTag('li');
    } ?>
</ul>