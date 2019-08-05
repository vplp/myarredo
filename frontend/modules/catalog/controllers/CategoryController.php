<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Response;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Collection, Product, Category, Factory, Types, SubTypes, Specification, Colors
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
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'ajax-get-types' => ['post'],
                    'ajax-get-category' => ['post'],
                ],
            ],
            [
                'class' => \yii\filters\HttpCache::class,
                //'only' => ['list'],
                'lastModified' => function ($action, $params) {
                    $q = new \yii\db\Query();
                    return $q->from(Product::tableName())->max('updated_at');
                }
            ],
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new Product();

        $group = [];

        Yii::$app->catalogFilter->parserUrl();

        $keys = Yii::$app->catalogFilter->keys;
        $queryParams = Yii::$app->catalogFilter->params;

        if (isset($queryParams[$keys['category']])) {
            $group = $queryParams[$keys['category']];
        }

        $category = Category::getWithProduct($queryParams);
        $types = Types::getWithProduct($queryParams);
        $subtypes = SubTypes::getWithProduct($queryParams);
        $style = Specification::getWithProduct($queryParams);
        $factory = Factory::getWithProduct($queryParams);
        $colors = Colors::getWithProduct($queryParams);

        $min = Product::minPrice(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));
        $max = Product::maxPrice(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        $price_range = [
            'min' => $min,
            'max' => $max
        ];

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        Yii::$app->metatag->render();

        if (!empty($models->getModels()) && !empty($queryParams[$keys['colors']])) {
            $this->listSeoColors();
        } elseif (!empty($models->getModels())) {
            $this->listSeo();
        } else {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        }

        if (empty($models->getModels())) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, nofollow',
            ]);
        }

        return $this->render('list', [
            'group' => $group,
            'category' => $category,
            'types' => $types,
            'subtypes' => $subtypes,
            'style' => $style,
            'factory' => $factory,
            'colors' => $colors,
            'price_range' => $price_range,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
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
                'alias',
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
                    ->andFilterWhere([Types::tableName() . '.alias' => Yii::$app->getRequest()->post('type_alias')])
                    ->all(),
                'alias',
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
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAjaxGetFilter()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $category = ArrayHelper::map(Category::findBase()->all(), 'alias', 'lang.title');
            $types = ArrayHelper::map(Types::getWithProduct([]), 'alias', 'lang.title');

            $html = $this->renderPartial('ajax_get_filter', [
                'category' => $category,
                'types' => $types,
            ]);

            return ['success' => 1, 'html' => $html];
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

        $noIndex = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        $pageDescription[] = Yii::t('app', 'Хотите купить');

        /**
         * colors
         */

        if (!empty($params[$keys['colors']])) {
            $models = Colors::findByAlias($params[$keys['colors']]);

            $colors = [];
            foreach ($models as $model) {
                $colors[] = $model['lang']['plural_title'];
            }

            $pageTitle[] = implode(', ', $colors);
            $pageH1[] = implode(', ', $colors);
            $pageDescription[] = implode(', ', $colors);

//            $this->breadcrumbs[] = [
//                'label' => implode(', ', $colors),
//                'url' => Yii::$app->catalogFilter->createUrl([$keys['colors'] => $params[$keys['colors']]])
//            ];
        }

        /**
         * category
         */

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


        /**
         * factory
         */

        if (!empty($params[$keys['factory']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            if (count($params[$keys['factory']]) > 1) {
                $noIndex = 1;
            }

            if (count($params) == 1 && count($params[$keys['factory']]) == 1) {
                $noIndex = 1;
            }

//            $pageTitle[] = implode(', ', $factory);
//            $pageH1[] = implode(', ', $factory);
//            $pageDescription[] = implode(', ', $factory);

//            $this->breadcrumbs[] = [
//                'label' => implode(', ', $factory),
//                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]])
//            ];
        }

        /**
         * style
         */

        if (!empty($params[$keys['style']])) {
            $models = Specification::findByAlias($params[$keys['style']]);

            if (count($params[$keys['style']]) > 1) {
                $noIndex = 1;
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

        /**
         * price
         */

        if (isset($params[$keys['price']])) {
            $noIndex = 1;
        }

        if (count($params) > 3) {
            $noIndex = 1;
        }

        /**
         * set options
         */

        $seo_title = implode(' ', $pageTitle) .
            ' | ' .
            Yii::t('app', 'Купить') .
            ' ' .
            implode(' ', $pageTitle) .
            ' ' .
            Yii::t('app', 'в') .
            ' ' .
            Yii::$app->city->getCityTitleWhere();

        $pageDescription[] = Yii::t('app', 'в') .
            ' ' .
            Yii::$app->city->getCityTitleWhere() .
            '? ' .
            Yii::t(
                'app',
                'Широкий выбор мебели от итальянских производителей в интернет-магазине Myarredo'
            ) .
            ' ' .
            Yii::t('app', 'Звоните') .
            '! +7 (812)336-42-86.' .

            $this->title = Yii::$app->metatag->seo_title
                ? Yii::$app->metatag->seo_title
                : $seo_title;

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => implode(' ', $pageDescription),
            ]);
        }

        if ($noIndex) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        } elseif (Yii::$app->getRequest()->get('page')) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'index, follow',
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

        $noIndex = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        /**
         * category
         */

        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $this->breadcrumbs[] = [
                'label' => $model['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]])
            ];
        }

        $pageDescription[] = Yii::$app->city->getCityTitle() . ': ' . Yii::t('app', 'Заказать');

        /**
         * type
         */

        if (!empty($params[$keys['type']])) {
            $models = Types::findByAlias($params[$keys['type']]);

            if (count($params[$keys['type']]) > 1) {
                $noIndex = 1;
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['type'] => $params[$keys['type']]])
            ];
        }

        /**
         * subtypes
         */

        if (!empty($params[$keys['subtypes']])) {
            $models = SubTypes::findByAlias($params[$keys['subtypes']]);

            if (count($params[$keys['subtypes']]) > 1) {
                $noIndex = 1;
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

        /**
         * style
         */

        if (!empty($params[$keys['style']])) {
            $models = Specification::findByAlias($params[$keys['style']]);

            if (count($params[$keys['style']]) > 1) {
                $noIndex = 1;
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
                'url' => Yii::$app->catalogFilter->createUrl([$keys['style'] => $params[$keys['style']]])
            ];
        }

        /**
         * collection
         */

        if (!empty($params[$keys['collection']])) {
            $collection = Collection::findById($params[$keys['collection']][0]);

            $pageTitle[] = Yii::t('app', 'Коллекция мебели') . ' ' . $collection['title'];
            $pageH1[] = Yii::t('app', 'Коллекция') . ' ' . $collection['title'];
            $pageDescription[] = Yii::t('app', 'Коллекция') . ' ' . $collection['title'];

            $this->breadcrumbs[] = [
                'label' => Yii::t('app', 'Коллекция') . ' ' . $collection['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['collection'] => $params[$keys['collection']]])
            ];
        }

        /**
         * category
         */

        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $pageTitle[] = $model['lang']['title'];
            $pageH1[] = $model['lang']['title'];
        }

        /**
         * factory
         */

        if (!empty($params[$keys['factory']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            if (count($params[$keys['factory']]) > 1) {
                $noIndex = 1;
            }

            if (count($params) == 1 && count($params[$keys['factory']]) == 1) {
                $noIndex = 1;
            }

            $pageTitle[] = implode(', ', $factory);
            $pageH1[] = implode(', ', $factory);
            $pageDescription[] = implode(', ', $factory);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $factory),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]])
            ];
        }

        /**
         * price
         */

        if (isset($params[$keys['price']])) {
            $noIndex = 1;
        }

        if (count($params) > 3) {
            $noIndex = 1;
        }

        $pageDescription[] = Yii::t('app', 'из Италии');

        /**
         * factory
         */

        if (count($params) == 2 && !empty($params[$keys['factory']]) &&
            count($params[$keys['factory']]) == 1 &&
            !empty($params[$keys['collection']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            $collection = Collection::findById($params[$keys['collection']][0]);

            $pageH1 = [];
            $pageH1[] = Yii::t('app', 'Итальянская мебель фабрики') .
                ' ' .
                implode(', ', $factory) . ' — ' .
                mb_strtolower(Yii::t('app', 'Коллекция')) . ' ' . $collection['title'];
        }

        /**
         * set options
         */

        $pageTitle[] = Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere();
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

        if ($noIndex) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        } elseif (Yii::$app->getRequest()->get('page')) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'index, follow',
            ]);
        }

        Yii::$app->metatag->seo_h1 = (Yii::$app->metatag->seo_h1 != '')
            ? Yii::$app->metatag->seo_h1
            : implode(', ', $pageH1);

        return $this;
    }
}
