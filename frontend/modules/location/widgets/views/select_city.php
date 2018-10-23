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

        if (in_array(Yii::$app->controller->action->id, ['sale', 'sale-product'])) {
            $url = $cityCountry->getSubDomainUrl();
        } else {
            $url = $cityCountry->getSubDomainUrl() . '/' . Yii::$app->request->pathInfo;
        }

        echo Html::a(
            $cityCountry['lang']['title'],
            $url,
            ['rel' => 'nofollow']
        );
        echo Html::endTag('li');
    } ?>
</ul>