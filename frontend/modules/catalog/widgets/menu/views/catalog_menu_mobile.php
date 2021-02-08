<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Category, Types
};

/**
 * @var $model Category
 * @var $category Category
 * @var $categorySale Category
 * @var $categorySaleItaly Category
 */

$categories = [];
foreach ($category as $model) {
    $keys = Yii::$app->catalogFilter->keys;
    $types = Types::getWithProduct([$keys['category'] =>$model[Yii::$app->languages->getDomainAlias()]]);

    $ldata = [];
    foreach ($types as $type) {
        $params = [];
        $params[$keys['category']] = $model[Yii::$app->languages->getDomainAlias()];
        $params[$keys['type']][] = $type[Yii::$app->languages->getDomainAlias()];
        $ldata[] = [
            'link' => Yii::$app->catalogFilter->createUrl($params),
            'text' => $type['lang']['title'] ?? ''
        ];
    }

    $categories[] = [
        'llink' => Category::getUrl($model[Yii::$app->languages->getDomainAlias()]),
        'ltext' => $model['lang']['title'],
        'limglink' => Category::getImage($model['image_link3']),
        'lcount' => $model['count'],
        'lopen' => 0,
        'ldata' => $ldata
    ];
}

$categoriesSale = [];
foreach ($categorySale as $model) {
    $keys = Yii::$app->catalogFilter->keys;
    $types = Types::getWithSale([$keys['category'] => $model[Yii::$app->languages->getDomainAlias()]]);

    $ldata = [];
    foreach ($types as $type) {
        $params = [];
        $params[$keys['category']] = $model[Yii::$app->languages->getDomainAlias()];
        $params[$keys['type']][] = $type[Yii::$app->languages->getDomainAlias()];
        $ldata[] = [
            'link' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale/list'),
            'text' => $type['lang']['title'] ?? ''
        ];
    }

    $categoriesSale[] = [
        'llink' => Category::getUrl( $model[Yii::$app->languages->getDomainAlias()], '/catalog/sale/list'),
        'ltext' => $model['lang']['title'],
        'limglink' => Category::getImage($model['image_link3']),
        'lcount' => $model['count'],
        'lopen' => 0,
        'ldata' => $ldata
    ];
}

$categoriesSaleItaly = [];
foreach ($categorySaleItaly as $model) {
    $keys = Yii::$app->catalogFilter->keys;
    $types = Types::getWithItalianProduct([$keys['category'] => $model[Yii::$app->languages->getDomainAlias()]]);

    $ldata = [];
    foreach ($types as $type) {
        $params = [];
        $params[$keys['category']] = $model[Yii::$app->languages->getDomainAlias()];
        $params[$keys['type']][] = $type[Yii::$app->languages->getDomainAlias()];
        $ldata[] = [
            'link' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale-italy/list'),
            'text' => $type['lang']['title'] ?? ''
        ];
    }

    $categoriesSaleItaly[] = [
        'llink' => Category::getUrl($model[Yii::$app->languages->getDomainAlias()], '/catalog/sale-italy/list'),
        'ltext' => $model['lang']['title'],
        'limglink' => Category::getImage($model['image_link3']),
        'lcount' => $model['count'],
        'lopen' => 0,
        'ldata' => $ldata
    ];
}

$MenuDataArray = array(
    'transtexts' => array(
        'allwiewText' => Yii::t('app', 'Смотреть все')
    ),
    'menulist' => array(
        array(
            'link' => Url::toRoute(['/catalog/sale/list']),
            'text' => Yii::t('app', 'Sale'),
            'show' => DOMAIN_TYPE != 'com' ? 1 : 0,
            'levelisset' => !empty($categoriesSale),
            'levelopen' => 0,
            'levelData' => $categoriesSale
        ),
//        array(
//            'link' => Url::toRoute(['/catalog/sale-italy/list']),
//            'text' => Yii::t('app', 'Sale in Italy'),
//            'show' => 1,
//            'levelisset' => !empty($categoriesSaleItaly),
//            'levelopen' => 0,
//            'levelData' => $categoriesSaleItaly
//        ),
        array(
            'link' => '/catalog/category/list',
            'text' => Yii::t('app', 'Catalog of furniture'),
            'show' => 1,
            'levelisset' => !empty($categories),
            'levelopen' => 1,
            'levelData' => $categories
        ),
        array(
            'link' => Url::toRoute(['/catalog/factory/list']),
            'text' => Yii::t('app', 'Фабрики'),
            'show' => 1,
            'levelisset' => 0,
            'levelopen' => 0,
            'levelData' => array()
        ),
        array(
            'link' => Url::toRoute(['/page/page/view', 'alias' => 'about']),
            'text' => Yii::t('app', 'About the project'),
            'show' => 1,
            'levelisset' => 0,
            'levelopen' => 0,
            'levelData' => array()
        ),
        array(
            'link' => Url::toRoute(['/page/page/view', 'alias' => 'contacts']),
            'text' => Yii::t('app', 'Где купить'),
            'show' => 1,
            'levelisset' => 0,
            'levelopen' => 1,
            'levelData' => array()
        )
    )
);
?>

<div id="mob_menu_list">
    <!-- Vue js component  -->
    <mob-menu-list></mob-menu-list>
</div>

<script>
mobMenuData = <?php echo json_encode($MenuDataArray); ?>;
</script>
