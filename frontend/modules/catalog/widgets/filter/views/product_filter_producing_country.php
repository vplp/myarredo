<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/** @var $filterParams [] */
/** @var $keys [] */
/** @var $route string */
/** @var $category Category */
/** @var $types [] */
/** @var $subtypes [] */
/** @var $style [] */
/** @var $factory [] */
/** @var $collection [] */
/** @var $factory_first_show [] */
/** @var $colors [] */
/** @var  $diameterRange [] */
/** @var  $widthRange [] */
/** @var  $lengthRange [] */
/** @var  $heightRange [] */
/** @var  $apportionmentRange [] */
/** @var  $sizesLink string */
/** @var $priceRange [] */
/** @var $producing_country [] */

?>

<?php if ($producing_country) { ?>
    <div class="one-filter">
        <?= Html::a(
            Yii::t('app', 'Producing country'),
            'javascript:void(0);',
            ['class' => 'filt-but']
        ) ?>
        <div class="list-item">
            <?php foreach ($producing_country as $item) {
                $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class , 'rel' => 'nofollow']);
                ?>
                <div class="filter-group">
                    <div class="my-checkbox"></div><?= $item['title'] ?>
                </div>
                <span><?= $item['count'] ?></span>
                <?php
                echo Html::endTag('a');
            } ?>
        </div>
    </div>
<?php } ?>
