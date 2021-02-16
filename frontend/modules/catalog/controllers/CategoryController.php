<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Response;
use frontend\components\BaseController;
use frontend\modules\catalog\widgets\filter\{
    ProductFilter, ProductFilterSizes
};
use frontend\modules\catalog\models\{Collection,
    Product,
    Category,
    Factory,
    ProductStatsDays,
    Types,
    SubTypes,
    Specification,
    Colors,
    ProductRelSpecification
};

/**
 * Class CategoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class CategoryController extends BaseController
{
    public $title = "Category";

    public $defaultAction = 'list';

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'ajax-get-types' => ['post'],
                    'ajax-get-category' => ['post'],
                    'ajax-get-filter' => ['post'],
                    'ajax-get-filter-sizes' => ['post'],
                    'ajax-get-filter-on-main' => ['post'],
                ],
            ],
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['list'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = Product::findLastUpdated();
                    return $model != null ? $model['updated_at'] : time();
                },
                'etagSeed' => function ($action, $params) {
                    $model = Product::findLastUpdated();
                    return serialize([
                        $model['lang']['title'],
                        $model['lang']['description']
                    ]);
                }
            ];
        }

        return $behaviors;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new Product();

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

        $bestsellers = ProductStatsDays::find()
            ->select([
                ProductStatsDays::tableName() . '.product_id',
                'count(' . ProductStatsDays::tableName() . '.product_id) as count',
                'sum(' . ProductStatsDays::tableName() . '.views) as views'
            ])
            ->groupBy(ProductStatsDays::tableName() . '.product_id')
            ->orderBy(['views' => SORT_DESC])
            ->asArray()
            ->limit(30)
            ->cache(7200)
            ->all();

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
            'bestsellers' => ArrayHelper::map($bestsellers, 'product_id', 'product_id'),
        ]);
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAjaxGetTypes()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $keys = Yii::$app->catalogFilter->keys;
            $params = Yii::$app->catalogFilter->params;

            $params[$keys['category']] = Yii::$app->getRequest()->post('category_alias');

            $types = ArrayHelper::map(
                Types::getWithProduct($params),
                Yii::$app->languages->getDomainAlias(),
                'lang.title'
            );

            $options = '';
            $options .= '<option value="">' . Yii::t('app', 'Предмет') . '</option>';
            foreach ($types as $id => $title) {
                $options .= '<option value="' . $id . '">' . $title . '</option>';
            }

            return ['success' => 1, 'options' => $options];
        }
    }

    /**
     * @return array
     */
    public function actionAjaxGetCategory()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $category = ArrayHelper::map(
                Category::findBase()
                    ->innerJoinWith(["types"])
                    ->andFilterWhere([
                        Types::tableName() . '.' . Yii::$app->languages->getDomainAlias() => Yii::$app->getRequest()->post('type_alias')])
                    ->all(),
                Yii::$app->languages->getDomainAlias(),
                'lang.title'
            );

            $options = '';
            $options .= '<option value="">' . Yii::t('app', 'Category') . '</option>';
            foreach ($category as $id => $title) {
                $options .= '<option value="' . $id . '">' . $title . '</option>';
            }

            return ['success' => 1, 'options' => $options];
        }
    }

    /**
     * @return array
     */
    public function actionAjaxGetNovelty()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $models = Product::findBaseArray()
                ->select([
                    Product::tableName() . '.id',
                    Product::tableName() . '.alias',
                    Product::tableName() . '.alias_en',
                    Product::tableName() . '.alias_it',
                    Product::tableName() . '.alias_de',
                    Product::tableName() . '.alias_he',
                    Product::tableName() . '.image_link',
                    Product::tableName() . '.factory_id',
                    Product::tableName() . '.removed',
                    Product::tableName() . '.price_from',
                    Product::tableName() . '.currency',
                    ProductLang::tableName() . '.title',
                ])
                ->andWhere(['onmain' => '1'])
                ->cache(7200)
                ->all();

            $i = 0;
            $_models = [];

            foreach ($models as $key => $model) {
                if ($key % 8 == 0) {
                    $i++;
                }
                $_models[$i][] = $model;
            }

            $models = $_models;

            $html = $this->renderPartial('ajax_get_novelty', ['models' => $models]);

            return ['success' => 1, 'html' => $html];
        }
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAjaxGetFilterOnMain()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $category = ArrayHelper::map(Category::findBase()->all(), Yii::$app->languages->getDomainAlias(), 'lang.title');
            $types = ArrayHelper::map(Types::getWithProduct([]), Yii::$app->languages->getDomainAlias(), 'lang.title');

            $html = $this->renderPartial('ajax_get_filter', [
                'category' => $category,
                'types' => $types,
            ]);

            return ['success' => 1, 'html' => $html];
        }
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
                'html' => ProductFilter::widget([
                    'route' => Yii::$app->getRequest()->post('link'),
                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
                ])
            ];
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionAjaxGetFilterSizes()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return [
                'success' => 1,
                'html' => ProductFilterSizes::widget([
                    'modelProductRelSpecificationClass' => ProductRelSpecification::class,
                    'route' => Yii::$app->getRequest()->post('link'),
                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
                ])
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function listSeoColors()
    {
        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Каталог итальянской мебели, цены на мебель из Италии'),
            'url' => ['/catalog/category/list']
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]])
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
                $type[] = count($params[$keys['type']]) == 1 ? $model['lang']['plural_name'] : $model['lang']['title'];
            }

            $pageTitle[] = implode(', ', $type);
            $pageH1[] = implode(' - ', $type);
            $pageDescription[] = implode(', ', $type);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $type),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['type'] => $params[$keys['type']]])
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['subtypes'] => $params[$keys['subtypes']]])
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]])
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['style'] => $params[$keys['style']]])
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

        if (isset($params[$keys['producing_country']])) {
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
            $seo_title .= ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere();
            $pageDescription[] = Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere() . '?';
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
            'label' => Yii::t('app', 'Каталог итальянской мебели, цены на мебель из Италии'),
            'url' => ['/catalog/category/list']
        ];

        $this->noIndex = 0;
        $pageTitle = $pageH1 = $pageDescription = $alternateParamsUrl = [];

        /** category */
        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $this->breadcrumbs[] = [
                'label' => $model['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]])
            ];

            $alternateParamsUrl['ru'][$keys['category']] = $model['alias'];
            $alternateParamsUrl['en'][$keys['category']] = $model['alias_en'];
            $alternateParamsUrl['it'][$keys['category']] = $model['alias_it'];
            $alternateParamsUrl['de'][$keys['category']] = $model['alias_de'];
            //$alternateParamsUrl['he'][$keys['category']] = $model['alias_he'];
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

                $alternateParamsUrl['ru'][$keys['type']][] = $model['alias'];
                $alternateParamsUrl['en'][$keys['type']][] = $model['alias_en'];
                $alternateParamsUrl['it'][$keys['type']][] = $model['alias_it'];
                $alternateParamsUrl['de'][$keys['type']][] = $model['alias_de'];
                //$alternateParamsUrl['he'][$keys['type']][] = $model['alias_he'];
            }

            $pageTitle[] = implode(', ', $type);
            $pageH1[] = implode(' - ', $type);
            $pageDescription[] = implode(', ', $type);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $type),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['type'] => $params[$keys['type']]])
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

                $alternateParamsUrl['ru'][$keys['subtypes']][] = $model['alias'];
                $alternateParamsUrl['en'][$keys['subtypes']][] = $model['alias'];
                $alternateParamsUrl['it'][$keys['subtypes']][] = $model['alias'];
                $alternateParamsUrl['de'][$keys['subtypes']][] = $model['alias'];
            }

            $pageTitle[] = implode(', ', $subtypes);
            $pageH1[] = implode(' - ', $subtypes);
            $pageDescription[] = implode(', ', $subtypes);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $subtypes),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['subtypes'] => $params[$keys['subtypes']]])
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

                $alternateParamsUrl['ru'][$keys['style']][] = $model['alias'];
                $alternateParamsUrl['en'][$keys['style']][] = $model['alias_en'];
                $alternateParamsUrl['it'][$keys['style']][] = $model['alias_it'];
                $alternateParamsUrl['de'][$keys['style']][] = $model['alias_de'];
                //$alternateParamsUrl['he'][$keys['style']][] = $model['alias_he'];
            }

            $pageTitle[] = Yii::t('app', 'Стиль') . ' ' . implode(', ', $style);
            $pageH1[] = implode(' - ', $style);
            $pageDescription[] = Yii::t('app', 'Стиль') . ': ' . implode(' - ', $style);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $style),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['style'] => $params[$keys['style']]])
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

                $alternateParamsUrl['ru'][$keys['collection']] = $params[$keys['collection']];
                $alternateParamsUrl['en'][$keys['collection']] = $params[$keys['collection']];
                $alternateParamsUrl['it'][$keys['collection']] = $params[$keys['collection']];
                $alternateParamsUrl['de'][$keys['collection']] = $params[$keys['collection']];
            }

            $pageTitle[] = Yii::t('app', 'Коллекция мебели') . ' ' . implode(', ', $collections);
            $pageH1[] = Yii::t('app', 'Коллекция') . ' ' . implode(', ', $collections);
            $pageDescription[] = Yii::t('app', 'Коллекция') . ' ' . implode(', ', $collections);

            $this->breadcrumbs[] = [
                'label' => Yii::t('app', 'Коллекция') . ' ' . implode(', ', $collections),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['collection'] => $params[$keys['collection']]])
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

                $alternateParamsUrl['ru'][$keys['factory']][] = $model['alias'];
                $alternateParamsUrl['en'][$keys['factory']][] = $model['alias'];
                $alternateParamsUrl['it'][$keys['factory']][] = $model['alias'];
                $alternateParamsUrl['de'][$keys['factory']][] = $model['alias'];
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]])
            ];
        }

        /** price */
        if (isset($params[$keys['price']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['price']] = $params[$keys['price']];
            $alternateParamsUrl['en'][$keys['price']] = $params[$keys['price']];
            $alternateParamsUrl['it'][$keys['price']] = $params[$keys['price']];
            $alternateParamsUrl['de'][$keys['price']] = $params[$keys['price']];
        }

        if (isset($params[$keys['diameter']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['diameter']] = $params[$keys['diameter']];
            $alternateParamsUrl['en'][$keys['diameter']] = $params[$keys['diameter']];
            $alternateParamsUrl['it'][$keys['diameter']] = $params[$keys['diameter']];
            $alternateParamsUrl['de'][$keys['diameter']] = $params[$keys['diameter']];
        }

        if (isset($params[$keys['width']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['width']] = $params[$keys['width']];
            $alternateParamsUrl['en'][$keys['width']] = $params[$keys['width']];
            $alternateParamsUrl['it'][$keys['width']] = $params[$keys['width']];
            $alternateParamsUrl['de'][$keys['width']] = $params[$keys['width']];
        }

        if (isset($params[$keys['length']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['length']] = $params[$keys['length']];
            $alternateParamsUrl['en'][$keys['length']] = $params[$keys['length']];
            $alternateParamsUrl['it'][$keys['length']] = $params[$keys['length']];
            $alternateParamsUrl['de'][$keys['length']] = $params[$keys['length']];
        }

        if (isset($params[$keys['height']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['height']] = $params[$keys['height']];
            $alternateParamsUrl['en'][$keys['height']] = $params[$keys['height']];
            $alternateParamsUrl['it'][$keys['height']] = $params[$keys['height']];
            $alternateParamsUrl['de'][$keys['height']] = $params[$keys['height']];
        }

        if (isset($params[$keys['apportionment']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['apportionment']] = $params[$keys['apportionment']];
            $alternateParamsUrl['en'][$keys['apportionment']] = $params[$keys['apportionment']];
            $alternateParamsUrl['it'][$keys['apportionment']] = $params[$keys['apportionment']];
            $alternateParamsUrl['de'][$keys['apportionment']] = $params[$keys['apportionment']];
        }

        if (isset($params[$keys['producing_country']])) {
            $this->noIndex = 1;

            $alternateParamsUrl['ru'][$keys['producing_country']] = $params[$keys['producing_country']];
            $alternateParamsUrl['en'][$keys['producing_country']] = $params[$keys['producing_country']];
            $alternateParamsUrl['it'][$keys['producing_country']] = $params[$keys['producing_country']];
            $alternateParamsUrl['de'][$keys['producing_country']] = $params[$keys['producing_country']];
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

        if (in_array(Yii::$app->city->getCityId(), [4, 159, 160, 161])) {
            if (!empty($alternateParamsUrl)) {
                foreach ($alternateParamsUrl as $lang => $paramsUrl) {
                    if ($lang == 'en') {
                        $href = 'https://www.myarredo.com/en';
                    } elseif ($lang == 'it') {
                        $href = 'https://www.myarredo.com/it';
                    } elseif ($lang == 'de') {
                        $href = 'https://www.myarredo.de';
                    } elseif ($lang == 'he') {
                        $href = 'https://www.myarredo.co.il';
                    } else {
                        $href = 'https://www.myarredo.ru';
                    }

                    $currentLang = substr(Yii::$app->language, 0, 2);

                    $url = str_replace($currentLang . '/', '', Yii::$app->catalogFilter->createUrl($paramsUrl, ['']));

                    Yii::$app->view->registerLinkTag([
                        'rel' => 'alternate',
                        'href' => $href . $url,
                        'hreflang' => $lang
                    ]);
                }
            } else {
                $alternateUrl = [
                    'ru' => 'https://www.myarredo.ru/catalog/',
                    'en' => 'https://www.myarredo.com/en/catalog/',
                    'it' => 'https://www.myarredo.com/it/catalog/',
                    'de' => 'https://www.myarredo.de/catalog/'
                ];

                foreach ($alternateUrl as $lang => $url) {
                    Yii::$app->view->registerLinkTag([
                        'rel' => 'alternate',
                        'href' => $url,
                        'hreflang' => $lang
                    ]);
                }
            }
        }

        Yii::$app->metatag->seo_h1 = (Yii::$app->metatag->seo_h1 != '')
            ? Yii::$app->metatag->seo_h1
            : implode(', ', $pageH1);

        return $this;
    }
}
