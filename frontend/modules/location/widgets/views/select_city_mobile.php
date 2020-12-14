<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\location\models\{
    Country, City
};

/**
 * @var $country Country
 * @var $city City
 */

?>

<ul class="mobile-city-list js-list-container">
    <?php
    foreach ($country['cities'] as $cityCountry) {
        $option = ($cityCountry['id'] == $city['id']) ? ['class' => 'active'] : [];

        echo Html::beginTag('li', $option);

        if (in_array(Yii::$app->controller->id, ['sale'])) {
            $url = City::getSubDomainUrl($cityCountry);
        } else {
            $url = City::getSubDomainUrl($cityCountry) . '/' . Yii::$app->request->pathInfo;
        }

        echo Html::a(
            $cityCountry['lang']['title'],
            $url,
            ['rel' => 'nofollow']
        );

        echo Html::endTag('li');
    } ?>
</ul>
