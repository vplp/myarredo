<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    Collection, Product, Category, Factory, Types, SubTypes, Specification, Colors, ProductRelSpecification
};

/**
 * Class ProductFilterProducingCountry
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class ProductFilterProducingCountry extends Widget
{
    /** @var string */
    public $view = 'product_filter_producing_country';

    /** @var string */
    public $route;

    /** @var object */
    public $colors = [];

    /** @var object */
    public $producing_country = [];

    /** @var object */
    public $catalogFilterParams = [];

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $keys = Yii::$app->catalogFilter->keys;

        $this->catalogFilterParams = $this->catalogFilterParams ?? Yii::$app->catalogFilter->params;

        $queryParams = $this->catalogFilterParams;

        $this->producing_country = Country::getWithProduct($queryParams);

        $producing_country = [];

        foreach ($this->producing_country as $key => $obj) {
            $params = $this->catalogFilterParams;

            if (
                !empty($params[$keys['producing_country']]) &&
                in_array($obj['alias'], $params[$keys['producing_country']])
            ) {
                $checked = 1;
                $params[$keys['producing_country']] = '';
            } else {
                $checked = 0;
                $params[$keys['producing_country']] = $obj['alias'];
            }

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $producing_country[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        return $this->render($this->view, [
            'keys' => $keys,
            'route' => $this->route,
            'producing_country' => $producing_country,
            'filter' => $this->catalogFilterParams
        ]);
    }
}
