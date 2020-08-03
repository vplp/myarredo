<?php

namespace frontend\modules\seo\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use frontend\modules\catalog\models\{
    Category, Types, SubTypes, Specification, Factory, Colors
};

/**
 * Class SitemapHtmlController
 *
 * @package frontend\modules\seo\controllers
 */
class SitemapHtmlController extends \frontend\components\BaseController
{
    public $title = '';

    public $defaultAction = 'index';

    protected $category = [];
    protected $types = [];
    protected $subtypes = [];
    protected $style = [];
    protected $colors = [];
    protected $factory = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $keys = Yii::$app->catalogFilter->keys;
        $route = ['/catalog/category/list'];

        /**
         * CATEGORY LIST
         */

        $this->category = Category::getWithProduct([]);

        $category = [];

        foreach ($this->category as $key => $obj) {
            $params = [];
            $params[$keys['category']] = $obj['alias'];

            $link = Yii::$app->catalogFilter->createUrl($params, $route);

            $category[$key] = [
                'link' => $link,
                'title' => $obj['lang']['title'],
            ];
        }

        /**
         * TYPE LIST
         */

        $this->types = Types::getWithProduct([]);

        $types = [];

        foreach ($this->types as $key => $obj) {
            $params = [];
            $params[$keys['type']] = [$obj['alias']];

            $link = Yii::$app->catalogFilter->createUrl($params, $route);

            $types[$key] = [
                'link' => $link,
                'title' => $obj['lang']['title'],
            ];
        }

        /**
         * SubTypes list
         */

        $this->subtypes = SubTypes::getWithProduct([]);

        $subtypes = [];

        foreach ($this->subtypes as $key => $obj) {
            $params = [];
            $params[$keys['subtypes']] = [$obj['alias']];

            $link = Yii::$app->catalogFilter->createUrl($params, $route);

            $subtypes[$key] = [
                'link' => $link,
                'title' => $obj['lang']['title'],
            ];
        }

        /**
         * STYLE LIST
         */

        $this->style = Specification::getWithProduct([]);

        $style = [];

        foreach ($this->style as $key => $obj) {
            $params = [];
            $params[$keys['style']] = [$obj[Yii::$app->languages->getDomainAlias()]];

            $link = Yii::$app->catalogFilter->createUrl($params, $route);

            $style[$key] = [
                'link' => $link,
                'title' => $obj['lang']['title'],
            ];
        }

        /**
         * COLORS LIST
         */

        $this->colors = Colors::getWithProduct([]);

        $colors = [];

        foreach ($this->colors as $key => $obj) {
            $params = [];
            $params[$keys['colors']] = [$obj['alias']];

            $link = Yii::$app->catalogFilter->createUrl($params, $route);

            $colors[$key] = [
                'link' => $link,
                'title' => $obj['lang']['title'],
            ];
        }

        /**
         * FACTORY LIST
         */

        $this->factory = Factory::findBase()->AsArray()->all();

        $factory = [];

        foreach ($this->factory as $key => $obj) {
            /** @var Factory $obj */

            $link = Factory::getUrl($obj['alias']);

            $factory[$key] = [
                'link' => $link,
                'title' => $obj['title'],
            ];
        }

        $this->title = Yii::t('app', 'Карта сайта');

        return $this->render('index', [
            'category' => $category,
            'types' => $types,
            'subtypes' => $subtypes,
            'style' => $style,
            'colors' => $colors,
            'factory' => $factory,
        ]);
    }
}
