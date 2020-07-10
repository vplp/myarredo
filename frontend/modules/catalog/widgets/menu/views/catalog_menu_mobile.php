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
    $types = Types::getWithProduct([$keys['category'] => Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2']]);

    $ldata = [];
    foreach ($types as $type) {
        $params = [];
        $params[$keys['category']] = Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2'];
        $params[$keys['type']][] = Yii::$app->city->domain != 'com' ? $type['alias'] : $type['alias2'];
        $ldata[] = [
            'link' => Yii::$app->catalogFilter->createUrl($params),
            'text' => $type['lang']['title']
        ];
    }

    $categories[] = [
        'llink' => Category::getUrl(Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2']),
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
    $types = Types::getWithSale([$keys['category'] => Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2']]);

    $ldata = [];
    foreach ($types as $type) {
        $params = [];
        $params[$keys['category']] = Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2'];
        $params[$keys['type']][] = Yii::$app->city->domain != 'com' ? $type['alias'] : $type['alias2'];
        $ldata[] = [
            'link' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale/list'),
            'text' => $type['lang']['title']
        ];
    }

    $categoriesSale[] = [
        'llink' => Category::getUrl(Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2'], '/catalog/sale/list'),
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
    $types = Types::getWithItalianProduct([$keys['category'] => Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2']]);

    $ldata = [];
    foreach ($types as $type) {
        $params = [];
        $params[$keys['category']] = Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2'];
        $params[$keys['type']][] = Yii::$app->city->domain != 'com' ? $type['alias'] : $type['alias2'];
        $ldata[] = [
            'link' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale-italy/list'),
            'text' => $type['lang']['title']
        ];
    }

    $categoriesSaleItaly[] = [
        'llink' => Category::getUrl(Yii::$app->city->domain != 'com' ? $model['alias'] : $model['alias2'], '/catalog/sale-italy/list'),
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
            'show' => Yii::$app->city->domain != 'com' ? 1 : 0,
            'levelisset' => !empty($categoriesSale),
            'levelopen' => 0,
            'levelData' => $categoriesSale
        ),
        array(
            'link' => Url::toRoute(['/catalog/sale-italy/list']),
            'text' => Yii::t('app', 'Sale in Italy'),
            'show' => 1,
            'levelisset' => !empty($categoriesSaleItaly),
            'levelopen' => 0,
            'levelData' => $categoriesSaleItaly
        ),
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
    // document ready
    window.addEventListener('DOMContentLoaded', function () {

        // data
        const mobMenuData = <?php echo json_encode($MenuDataArray); ?>;

        // Функционал для запуска если само Vue подключено Async
        var pendingVue = setInterval(function () {
            try {
                Vue;
            } catch (e) {
                return false;
            }
            startMenuInit();
        }, 300);

        function startMenuInit() {
            clearInterval(pendingVue);

            // Vue js
            Vue.component('mob-menu-list', {
                data: function () {
                    return {
                        mobdata: mobMenuData
                    }
                },
                methods: {
                    openTwolevel: function(item) {
                        item = !item; 
                        if (item) {
                            if (window.pageYOffset > 120) {
                                // window.scrollTo(pageXOffset, 0);
                                const el = document.getElementsByClassName('mobile-header');
                                setTimeout(function() {
                                    el[0].scrollIntoView({behavior: "smooth"});
                                },550);
                            }
                        }

                        return item;
                    }
                },
                template: 
                `<ul class="menu-list navigation">
                    <li v-for="oneItem in mobdata.menulist" v-if="oneItem.show" v-bind:class="{jshaslist : oneItem.levelisset}">
                        <a v-on:click="oneItem.levelopen = !oneItem.levelopen"
                        v-bind:class="{open: oneItem.levelopen}"
                        v-if="oneItem.levelisset"
                        href="javascript:void(0);">
                            {{ oneItem.text }}
                        </a>
                        <a v-else v-bind:href=oneItem.link>{{ oneItem.text }}</a>
                        
                        <div v-if="oneItem.levelisset" class="list-levelbox">
                            
                            <ul v-show="oneItem.levelopen" class="list-level">
                                <li v-for="twoLevel in oneItem.levelData" v-bind:class="{open: twoLevel.lopen}">
                                    <a href="javascript:void(0);"
                                    v-on:click="twoLevel.lopen = openTwolevel(twoLevel.lopen)">

                                        <div class="img-cont">
                                            <img v-bind:src=twoLevel.limglink alt="">
                                        </div>
                                        <span class="for-mobm-text">{{ twoLevel.ltext }}</span>
                                        <span class="count">{{ twoLevel.lcount }}</span>
                                    </a>
                                    <transition name="slidemenu">
                                        <ul class="three-llist" v-show="twoLevel.lopen">
                                            <li class="tl-panel">
                                                <button v-on:click="twoLevel.lopen = !twoLevel.lopen" class="btn-mobitem-close">
                                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                    <span class="for-onelevel-text"> 
                                                        {{ oneItem.text }}
                                                    </span>
                                                    <span class="for-twolevel-text"> 
                                                        {{ twoLevel.ltext }}
                                                    </span>
                                                </button>
                                            </li>
                                            <li v-for="threelev in twoLevel.ldata">
                                                <a v-bind:href=threelev.link>{{ threelev.text }}</a>
                                            </li>
                                            <li>
                                                <a v-bind:href=twoLevel.llink class="viewall-link">{{ mobdata.transtexts.allwiewText }}</a>
                                            </li>
                                        </ul>
                                    </transition>
                                </li>
                            </ul>
                            
                        </div>
                        
                    </li>
                </ul>`
            });

            // Vue init
            new Vue({
                el: '#mob_menu_list'
            });
        }
    });
</script>