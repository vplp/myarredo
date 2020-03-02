<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
//
use frontend\modules\catalog\models\{
    Collection, Product, Category, Factory, Types, SubTypes, Specification, Colors, ProductRelSpecification
};

/**
 * Class ProductFilter
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class ProductFilterSizes extends Widget
{
    /** @var string */
    public $view = 'product_filter_sizes';

    /** @var string */
    public $route;

    /** @var array */
    public $diameterRange = ['min' => 0, 'max' => 1];

    /** @var array */
    public $widthRange = ['min' => 0, 'max' => 1];

    /** @var array */
    public $lengthRange = ['min' => 0, 'max' => 1];

    /** @var array */
    public $heightRange = ['min' => 0, 'max' => 1];

    /** @var array */
    public $apportionmentRange = ['min' => 0, 'max' => 1];

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

        $this->diameterRange = ProductRelSpecification::getRange($queryParams, 42);
        $this->widthRange = ProductRelSpecification::getRange($queryParams, 8);
        $this->lengthRange = ProductRelSpecification::getRange($queryParams, 6);
        $this->heightRange = ProductRelSpecification::getRange($queryParams, 7);
        $this->apportionmentRange = ProductRelSpecification::getRange($queryParams, 67);

        $sizesParams = $this->catalogFilterParams;

        /** Diameter range */

        $diameterRange = [];

        if ($this->diameterRange) {
            // min
            if ($this->diameterRange['min']) {
                $diameterRange['min'] = [
                    'current' => !empty($params[$keys['diameter']])
                        ? $params[$keys['diameter']][0]
                        : $this->diameterRange['min'],
                    'default' => $this->diameterRange['min'],
                ];
            }

            // max
            if ($this->diameterRange['max']) {
                $diameterRange['max'] = [
                    'current' => !empty($params[$keys['diameter']])
                        ? $params[$keys['diameter']][1]
                        : $this->diameterRange['max'],
                    'default' => $this->diameterRange['max'],
                ];
            }

            if ($diameterRange && $diameterRange['min']['default'] != $diameterRange['max']['default']) {
                $sizesParams[$keys['diameter']] = ['{diameterMin}', '{diameterMax}'];
            }
        }

        /** Width range */

        $widthRange = [];

        if ($this->widthRange) {
            // min
            if ($this->widthRange['min']) {
                $widthRange['min'] = [
                    'current' => !empty($params[$keys['width']])
                        ? $params[$keys['width']][0]
                        : $this->widthRange['min'],
                    'default' => $this->widthRange['min'],
                ];
            }

            // max
            if ($this->widthRange['max']) {
                $widthRange['max'] = [
                    'current' => !empty($params[$keys['width']])
                        ? $params[$keys['width']][1]
                        : $this->widthRange['max'],
                    'default' => $this->widthRange['max'],
                ];
            }

            if ($widthRange && $widthRange['min']['default'] != $widthRange['max']['default']) {
                $sizesParams[$keys['width']] = ['{widthMin}', '{widthMax}'];
            }
        }

        /** Length range */

        $lengthRange = [];

        if ($this->lengthRange) {
            // min
            if ($this->lengthRange['min']) {
                $lengthRange['min'] = [
                    'current' => !empty($params[$keys['length']])
                        ? $params[$keys['length']][0]
                        : $this->lengthRange['min'],
                    'default' => $this->lengthRange['min'],
                ];
            }

            // max
            if ($this->lengthRange['max']) {
                $lengthRange['max'] = [
                    'current' => !empty($params[$keys['length']])
                        ? $params[$keys['length']][1]
                        : $this->lengthRange['max'],
                    'default' => $this->lengthRange['max'],
                ];
            }

            if ($lengthRange && $lengthRange['min']['default'] != $lengthRange['max']['default']) {
                $sizesParams[$keys['length']] = ['{lengthMin}', '{lengthMax}'];
            }
        }

        /** Height range */

        $heightRange = [];

        if ($this->heightRange) {
            // min
            if ($this->heightRange['min']) {
                $heightRange['min'] = [
                    'current' => !empty($params[$keys['height']])
                        ? $params[$keys['height']][0]
                        : $this->heightRange['min'],
                    'default' => $this->heightRange['min'],
                ];
            }

            // max
            if ($this->heightRange['max']) {
                $heightRange['max'] = [
                    'current' => !empty($params[$keys['height']])
                        ? $params[$keys['height']][1]
                        : $this->heightRange['max'],
                    'default' => $this->heightRange['max'],
                ];
            }

            if ($heightRange && $heightRange['min']['default'] != $heightRange['max']['default']) {
                $sizesParams[$keys['height']] = ['{heightMin}', '{heightMax}'];
            }
        }

        /** Apportionment range */

        $apportionmentRange = [];

        if ($this->apportionmentRange) {
            // min
            if ($this->apportionmentRange['min']) {
                $apportionmentRange['min'] = [
                    'current' => !empty($params[$keys['apportionment']])
                        ? $params[$keys['apportionment']][0]
                        : $this->apportionmentRange['min'],
                    'default' => $this->apportionmentRange['min'],
                ];
            }

            // max
            if ($this->apportionmentRange['max']) {
                $apportionmentRange['max'] = [
                    'current' => !empty($params[$keys['apportionment']])
                        ? $params[$keys['apportionment']][1]
                        : $this->apportionmentRange['max'],
                    'default' => $this->apportionmentRange['max'],
                ];
            }

            if ($apportionmentRange && $apportionmentRange['min']['default'] != $apportionmentRange['max']['default']) {
                $sizesParams[$keys['apportionment']] = ['{apportionmentMin}', '{apportionmentMax}'];
            }
        }

        $sizesLink = Yii::$app->catalogFilter->createUrl($sizesParams, [$this->route]);

        return $this->render($this->view, [
            'route' => $this->route,
            'diameterRange' => $diameterRange,
            'widthRange' => $widthRange,
            'lengthRange' => $lengthRange,
            'heightRange' => $heightRange,
            'apportionmentRange' => $apportionmentRange,
            'sizesLink' => $sizesLink,
            'filter' => $this->catalogFilterParams
        ]);
    }
}
