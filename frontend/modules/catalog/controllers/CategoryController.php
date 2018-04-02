<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Collection, Product, Category, Factory, Types, Specification
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
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $model = new Product();

        $group = [];

        if (isset(Yii::$app->catalogFilter->params['category'])) {
            $group = Yii::$app->catalogFilter->params['category'];
        }

        Yii::$app->catalogFilter->parserUrl();

        $category = Category::getWithProduct(Yii::$app->catalogFilter->params);
        $types = Types::getWithProduct(Yii::$app->catalogFilter->params);
        $style = Specification::getWithProduct(Yii::$app->catalogFilter->params);
        $factory = Factory::getWithProduct(Yii::$app->catalogFilter->params);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, Yii::$app->catalogFilter->params));

        Yii::$app->metatag->render();

        $this->seo();

        return $this->render('list', [
            'group' => $group,
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @return $this
     */
    public function seo()
    {
        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $this->breadcrumbs[] = [
            'label' => Yii::t('app','Каталог итальянской мебели, цены на мебель из Италии'),
            'url' => ['/catalog/category/list']
        ];

        $noindex = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        /**
         * query
         */

        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);


            $this->breadcrumbs[] = [
                'label' => $model['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]])
            ];
        }

        $pageDescription[] = Yii::$app->city->getCityTitle() . ': Заказать';

        if (!empty($params[$keys['type']])) {
            $models = Types::findByAlias($params[$keys['type']]);

            if (count($params[$keys['type']]) > 1) {
                $noindex = 1;
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

        if (!empty($params[$keys['style']])) {
            $models = Specification::findByAlias($params[$keys['style']]);

            if (count($params[$keys['style']]) > 1) {
                $noindex = 1;
            }

            $style = [];
            foreach ($models as $model) {
                $style[] = $model['lang']['title'];
            }

            $pageTitle[] = Yii::t('app','Стиль') . ' ' . implode(', ', $style);
            $pageH1[] = implode(' - ', $style);
            $pageDescription[] = Yii::t('app','Стиль') .': '. implode(' - ', $style);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $style),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['style'] => $params[$keys['style']]])
            ];
        }

        if (!empty($params[$keys['collection']])) {
            $collection = Collection::findById($params[$keys['collection']][0]);

            $pageTitle[] = Yii::t('app','Коллекция мебели') .' '. $collection['lang']['title'];
            $pageH1[] = Yii::t('app','Коллекция') .' '. $collection['lang']['title'];
            $pageDescription[] = Yii::t('app','Коллекция') .' '. $collection['lang']['title'];

            $this->breadcrumbs[] = [
                'label' => Yii::t('app','Коллекция') .' '. $collection['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['collection'] => $params[$keys['collection']]])
            ];
        }

        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $pageTitle[] = $model['lang']['title'];
            $pageH1[] = $model['lang']['title'];
        }

        if (!empty($params[$keys['factory']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            if (count($params[$keys['factory']]) > 1) {
                $noindex = 1;
            }

            $pageTitle[] = implode(', ', $factory);
            $pageH1[] = implode(', ', $factory);
            $pageDescription[] = implode(', ', $factory);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $factory),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]])
            ];
        }

        $pageDescription[] = Yii::t('app','из Италии');

        /**
         * set options
         */

        $pageTitle[] = Yii::t('app','Купить в') . ' ' . Yii::$app->city->getCityTitleWhere();
        $pageDescription[] = '. '.Yii::t('app','Широкий выбор мебели от итальянских производителей в интернет-магазине Myarredo');

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : (!empty($pageTitle)
                ? implode('. ', $pageTitle)
                : Yii::t('app','Каталог итальянской мебели, цены на мебель из Италии'));

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => implode(' ', $pageDescription),
            ]);
        }

        if ($noindex) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        } else if (isset($params[$keys['factory']]) && count($params) == 1 && count($params[$keys['factory']]) == 1) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        }

        $this->pageH1 = ($this->pageH1 != '')
            ? $this->pageH1
            : implode(', ', $pageH1);

        return $this;
    }

}
