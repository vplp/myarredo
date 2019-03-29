<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $country \frontend\modules\location\models\Country
 * @var $city \frontend\modules\location\models\City
 */

?>
<div class="cities-list">
    <div class="container large-container">
        <span class="title-h5"><?= Yii::t('app', 'Этот список городов размещен здесь для вашего удобства. Найдите свой город и купите итальянскую мебель по лучшей цене.') ?></span>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Город
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                foreach ($country['cities'] as $cityCountry) {
                    echo Html::a(
                        $cityCountry['lang']['title'],
                        $cityCountry->getSubDomainUrl(),
                        ['class' => 'dropdown-item']
                    );
                } ?>
            </div>
        </div>
        <div class="list-of-cities">
            <?php $currentLetter = '' ?>
            <?php
            foreach ($country['cities'] as $cityCountry) {
                if ($currentLetter != mb_substr($cityCountry['lang']['title'], 0, 1)) {
                    $currentLetter = mb_substr($cityCountry['lang']['title'], 0, 1);
                    echo Html::tag('span', $currentLetter);
                }
                echo Html::a(
                    $cityCountry['lang']['title'],
                    $cityCountry->getSubDomainUrl(),
                    ['rel' => 'nofollow']
                );
            }
            ?>
        </div>
    </div>
</div>
