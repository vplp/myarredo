<?php

namespace frontend\modules\catalog\controllers;

use frontend\modules\catalog\widgets\filter\CountriesFurnitureFilter;
use frontend\modules\catalog\widgets\filter\ProductFilterSizes;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Collection,
    Product,
    ItalianProduct,
    ItalianProductLang,
    search\ItalianProduct as filterItalianProductModel,
    ItalianProductStats,
    Category,
    Factory,
    Types,
    SubTypes,
    Specification,
    Colors,
    CountriesFurniture
};
use yii\web\Response;

/**
 * Class CountriesFurnitureController
 *
 * @package frontend\modules\catalog\controllers
 */
class CountriesFurnitureController extends BaseController
{
    public $label = "Countries furniture";

    public $title = "Countries furniture";

    public $defaultAction = 'list';

    protected $model = CountriesFurniture::class;

    protected $filterModel = CountriesFurniture::class;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['post', 'get'],
                    'ajax-get-filter' => ['post'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList()
    {
        $model = new CountriesFurniture();

        Yii::$app->catalogFilter->parserUrl();

        $keys = Yii::$app->catalogFilter->keys;
        $queryParams = Yii::$app->catalogFilter->params;

        $queryParams['defaultPageSize'] = 33;
        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        Yii::$app->metatag
            ->render()
            ->setImageUrl('https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . '/uploads/myarredo-ico.jpg')
            ->renderGraph();

        if (!empty($models->getModels()) && !empty($queryParams[$keys['colors']])) {
            $this->listSeoColors();
        } elseif (!empty($models->getModels())) {
            $this->listSeo();
        } else {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, nofollow',
            ]);
        }

        return $this->render('list/list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView(string $alias)
    {
        $model = Product::findByAlias($alias);

        if ($model == null) {
            $model = ItalianProduct::findByAlias($alias);
        }

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Countries furniture'),
            'url' => ['/catalog/countries-furniture/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;

            $params[$keys['category']] = $model['category'][0][Yii::$app->languages->getDomainAlias()];

            $this->breadcrumbs[] = [
                'label' => $model['category'][0]['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/countries-furniture/list'])
            ];
        }

        if (isset($model['types'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model['types']['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['types']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/countries-furniture/list'])
            ];
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 9) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $pageDescription[] = Yii::t('app', 'Стиль') . ': ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 2) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $pageDescription[] = Yii::t('app', 'Материал') . ': ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 4) {
                $array[] = $item['specification']['lang']['title'] .
                    ': ' .
                    $item['val'] . Yii::t('app', 'см');
            }
        }

        if (!empty($array)) {
            $pageDescription[] = implode(', ', $array);
        }

        if (DOMAIN_TYPE != 'com') {
            $pageTitle[] = Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere();
            $pageDescription[] = Yii::t('app', 'Купить в интернет-магазине Myarredo в') .
                ' ' . Yii::$app->city->getCityTitleWhere();
        }

        $pageTitle = implode('. ', $pageTitle);
        $pageDescription = implode('. ', $pageDescription);

        $this->title = $pageTitle;

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $pageDescription,
        ]);

        $lang = substr(Yii::$app->language, 0, 2);

        if (in_array(DOMAIN_TYPE, ['com']) && DOMAIN_NAME == 'myarredofamily') {
            $hrefCanonical = Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo;
        } elseif (in_array(DOMAIN_TYPE, ['de', 'fr', 'uk', 'co.il'])) {
            $hrefCanonical = Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo;
        } else {
            $hrefCanonical = Yii::$app->request->hostInfo . ($lang != 'ru' ? '/' . $lang . '/' : '/' ) . Yii::$app->request->pathInfo;
        }

        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => $hrefCanonical
        ]);

        Yii::$app->metatag->renderArrayGraph([
            'site_name' => 'Myarredo Family',
            'type' => 'article',
            'title' => $pageTitle,
            'description' => $pageDescription,
            'image' => Product::getImage($model['image_link']),
        ]);

        return $this->render(
            isset($model['price_new'])
                ? 'view/sale/view'
                : 'view/product/view',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionAjaxGetFilter()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return [
                'success' => 1,
                'html' => CountriesFurnitureFilter::widget([
                    'route' => Yii::$app->getRequest()->post('link'),
                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
                ])
            ];
        }
    }

//    /**
//     * @return array
//     * @throws \Exception
//     */
//    public function actionAjaxGetFilterSizes()
//    {
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
//
//            return [
//                'success' => 1,
//                'html' => ProductFilterSizes::widget([
//                    'route' => Yii::$app->getRequest()->post('link'),
//                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
//                ])
//            ];
//        }
//    }

    /**
     * @inheritdoc
     */
    public function listSeoColors()
    {
        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Countries furniture'),
            'url' => ['/catalog/countries-furniture/list']
        ];

        $this->noIndex = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        $pageDescription[] = Yii::t('app', 'Хотите купить');

        /** colors */
        if (!empty($params[$keys['colors']])) {
            $models = Colors::findByAlias($params[$keys['colors']]);

            if (count($params[$keys['colors']]) > 1) {
                $this->noIndex = 1;
            }

            $colors = [];
            foreach ($models as $model) {
                $colors[] = $model['lang']['plural_title'];
            }

            $pageTitle[] = implode(', ', $colors);
            $pageH1[] = implode(', ', $colors);
            $pageDescription[] = implode(', ', $colors);
        }

        /** category */
        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $pageTitle[] = $model['lang']['title'];
            $pageH1[] = $model['lang']['title'];
            $pageDescription[] = $model['lang']['title'];

            $this->breadcrumbs[] = [
                'label' => $model['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]], ['/catalog/countries-furniture/list'])
            ];
        }


        /** type */
        if (!empty($params[$keys['type']])) {
            $models = Types::findByAlias($params[$keys['type']]);

            if (count($params[$keys['type']]) > 1) {
                $this->noIndex = 1;
            }

            $type = [];
            foreach ($models as $model) {
                $type[] = $model['lang']['title'];
            }

            $pageTitle[] = implode(', ', $type);
            $pageH1[] = implode(' - ', $type);
            $pageDescription[] = implode(', ', $type);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $type),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['type'] => $params[$keys['type']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** subtypes */
        if (!empty($params[$keys['subtypes']])) {
            $models = SubTypes::findByAlias($params[$keys['subtypes']]);

            if (count($params[$keys['subtypes']]) > 1) {
                $this->noIndex = 1;
            }

            $subtypes = [];
            foreach ($models as $model) {
                $subtypes[] = $model['lang']['title'];
            }

            $pageTitle[] = implode(', ', $subtypes);
            $pageH1[] = implode(' - ', $subtypes);
            $pageDescription[] = implode(', ', $subtypes);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $subtypes),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['subtypes'] => $params[$keys['subtypes']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** factory */
        if (!empty($params[$keys['factory']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            if (count($params[$keys['factory']]) > 1) {
                $this->noIndex = 1;
            }

            if (count($params) == 1 && count($params[$keys['factory']]) == 1) {
                $this->noIndex = 1;
            }

            $pageTitle[] = implode(', ', $factory);
            $pageH1[] = implode(', ', $factory);
            $pageDescription[] = implode(', ', $factory);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $factory),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** style */
        if (!empty($params[$keys['style']])) {
            $models = Specification::findByAlias($params[$keys['style']]);

            if (count($params[$keys['style']]) > 1) {
                $this->noIndex = 1;
            }

            $style = [];
            foreach ($models as $model) {
                $style[] = $model['lang']['title'];
            }

            $pageTitle[] = Yii::t('app', 'в стиле') . ' ' . implode(', ', $style);
            $pageH1[] = Yii::t('app', 'в стиле') . ' ' . implode(', ', $style);
            $pageDescription[] = Yii::t('app', 'в стиле') . ' ' . implode(', ', $style);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $style),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['style'] => $params[$keys['style']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** price */
        if (isset($params[$keys['price']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['diameter']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['width']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['length']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['height']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['apportionment']])) {
            $this->noIndex = 1;
        }

        $countParams = 0;
        foreach ($params as $arr) {
            $countParams += count($arr);
        }

        if ($countParams > 3) {
            $this->noIndex = 1;
        }

        /**
         * set options
         */

        $seo_title = implode(' ', $pageTitle) .
            ' | ' .
            Yii::t('app', 'Купить') .
            ' ' .
            implode(' ', $pageTitle);

        if (DOMAIN_TYPE != 'com') {
            $seo_title .= Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere();
            $pageDescription[] = Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere() . '? ';
        }

        $pageDescription[] = Yii::t(
            'app',
            'Широкий выбор мебели от итальянских производителей в интернет-магазине Myarredo'
        );

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : $seo_title;

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => implode(' ', $pageDescription),
            ]);
        }

        if ($this->noIndex) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        } elseif (Yii::$app->getRequest()->get('page')) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        }

        Yii::$app->metatag->seo_h1 = (Yii::$app->metatag->seo_h1 != '')
            ? Yii::$app->metatag->seo_h1
            : implode(' ', $pageH1);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function listSeo()
    {
        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Countries furniture'),
            'url' => ['/catalog/countries-furniture/list']
        ];

        $this->noIndex = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        /** category */
        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $this->breadcrumbs[] = [
                'label' => $model['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]], ['/catalog/countries-furniture/list'])
            ];
        }

        if (DOMAIN_TYPE != 'com') {
            $pageDescription[] = Yii::$app->city->getCityTitle() . ': ' . Yii::t('app', 'Заказать');
        }

        /** type */
        if (!empty($params[$keys['type']])) {
            $models = Types::findByAlias($params[$keys['type']]);

            if (count($params[$keys['type']]) > 1) {
                $this->noIndex = 1;
            }

            $type = [];
            foreach ($models as $model) {
                $type[] = $model['lang']['title'];
            }

            $pageTitle[] = implode(', ', $type);
            $pageH1[] = implode(' - ', $type);
            $pageDescription[] = implode(', ', $type);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $type),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['type'] => $params[$keys['type']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** subtypes */
        if (!empty($params[$keys['subtypes']])) {
            $models = SubTypes::findByAlias($params[$keys['subtypes']]);

            if (count($params[$keys['subtypes']]) > 1) {
                $this->noIndex = 1;
            }

            $subtypes = [];
            foreach ($models as $model) {
                $subtypes[] = $model['lang']['title'];
            }

            $pageTitle[] = implode(', ', $subtypes);
            $pageH1[] = implode(' - ', $subtypes);
            $pageDescription[] = implode(', ', $subtypes);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $subtypes),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['subtypes'] => $params[$keys['subtypes']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** style */
        if (!empty($params[$keys['style']])) {
            $models = Specification::findByAlias($params[$keys['style']]);

            if (count($params[$keys['style']]) > 1) {
                $this->noIndex = 1;
            }

            $style = [];
            foreach ($models as $model) {
                $style[] = $model['lang']['title'];
            }

            $pageTitle[] = Yii::t('app', 'Стиль') . ' ' . implode(', ', $style);
            $pageH1[] = implode(' - ', $style);
            $pageDescription[] = Yii::t('app', 'Стиль') . ': ' . implode(' - ', $style);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $style),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['style'] => $params[$keys['style']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** collection */
        if (!empty($params[$keys['collection']])) {
            $models = Collection::findByIDs($params[$keys['collection']]);

            if (count($params[$keys['collection']]) > 1) {
                $this->noIndex = 1;
            }

            $collections = [];
            foreach ($models as $model) {
                $collections[] = $model['title'];
            }

            $pageTitle[] = Yii::t('app', 'Коллекция мебели') . ' ' . implode(', ', $collections);
            $pageH1[] = Yii::t('app', 'Коллекция') . ' ' . implode(', ', $collections);
            $pageDescription[] = Yii::t('app', 'Коллекция') . ' ' . implode(', ', $collections);

            $this->breadcrumbs[] = [
                'label' => Yii::t('app', 'Коллекция') . ' ' . implode(', ', $collections),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['collection'] => $params[$keys['collection']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** category */
        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $pageTitle[] = $model['lang']['title'];
            $pageH1[] = $model['lang']['title'];
            $pageDescription[] = $model['lang']['title'];
        }

        /** factory */
        if (!empty($params[$keys['factory']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            if (count($params[$keys['factory']]) > 1) {
                $this->noIndex = 1;
            }

            if (count($params) == 1 && count($params[$keys['factory']]) == 1) {
                $this->noIndex = 1;
            }

            $pageTitle[] = implode(', ', $factory);
            $pageH1[] = implode(', ', $factory);
            $pageDescription[] = implode(', ', $factory);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $factory),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]], ['/catalog/countries-furniture/list'])
            ];
        }

        /** price */
        if (isset($params[$keys['price']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['diameter']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['width']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['length']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['height']])) {
            $this->noIndex = 1;
        }

        if (isset($params[$keys['apportionment']])) {
            $this->noIndex = 1;
        }

        $countParams = 0;
        foreach ($params as $arr) {
            $countParams += count($arr);
        }

        if ($countParams > 3) {
            $this->noIndex = 1;
        }

        $pageDescription[] = Yii::t('app', 'из Италии');

        /** factory */
        if (count($params) == 2 && !empty($params[$keys['factory']]) &&
            count($params[$keys['factory']]) == 1 &&
            !empty($params[$keys['collection']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            $modelCollection = Collection::findByIDs($params[$keys['collection']]);
            $collections = [];
            foreach ($modelCollection as $model) {
                $collections[] = $model['title'];
            }

            $pageH1 = [];
            $pageH1[] = Yii::t('app', 'Итальянская мебель фабрики') .
                ' ' .
                implode(', ', $factory) . ' — ' .
                mb_strtolower(Yii::t('app', 'Коллекция')) . ' ' . implode(', ', $collections);
        }

        /**
         * set options
         */

        if (DOMAIN_TYPE != 'com') {
            $pageTitle[] = Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere();
        }

        $pageDescription[] = '. ' .
            Yii::t(
                'app',
                'Широкий выбор мебели от итальянских производителей в интернет-магазине Myarredo'
            );

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : (!empty($pageTitle)
                ? implode('. ', $pageTitle)
                : Yii::t('app', 'Каталог итальянской мебели, цены на мебель из Италии'));

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => implode(' ', $pageDescription),
            ]);
        }

        if ($this->noIndex) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        } elseif (Yii::$app->getRequest()->get('page')) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        }

        Yii::$app->metatag->seo_h1 = (Yii::$app->metatag->seo_h1 != '')
            ? Yii::$app->metatag->seo_h1
            : implode(', ', $pageH1);

        return $this;
    }
}
