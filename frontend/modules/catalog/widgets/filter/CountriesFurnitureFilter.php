<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    Collection,
    Product,
    Category,
    Factory,
    Types,
    SubTypes,
    Specification,
    Colors,
    ProductRelSpecification,
    CountriesFurniture
};

/**
 * Class CountriesFurnitureFilter
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class CountriesFurnitureFilter extends Widget
{
    /** @var string */
    public $view = 'countries_furniture_filter';

    /** @var string */
    public $route;

    /** @var object */
    public $category = [];

    /** @var object */
    public $types = [];

    /** @var object */
    public $subtypes = [];

    /** @var object */
    public $style = [];

    /** @var object */
    public $factory = [];

    /** @var object */
    public $collection = [];

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

    /** @var array */
    public $priceRange = ['min' => ['default' => 0], 'max' => ['default' => 0]];

    /** @var object */
    public $colors = [];

    /** @var object */
    public $catalogFilterParams = [];

    /** @var object */
    public $countries = [];

    /** @var object */
    public $cities = [];

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

        $this->countries = Country::getWithProduct($queryParams, true) + Country::getWithItalianProduct($queryParams, true);

        $this->category = Category::getWithProduct($queryParams, true) + Category::getWithItalianProduct($queryParams, true);
        $this->types = Types::getWithProduct($queryParams, true) + Types::getWithItalianProduct($queryParams, true);
        $this->subtypes = SubTypes::getWithProduct($queryParams, true) + SubTypes::getWithItalianProduct($queryParams, true);
        $this->style = Specification::getWithProduct($queryParams, true) + Specification::getWithItalianProduct($queryParams, true);
        $this->factory = Factory::getWithProduct($queryParams, true) + Factory::getWithItalianProduct($queryParams, true);

        if (isset($queryParams[$keys['factory']]) && count($queryParams[$keys['factory']]) == 1) {
            $this->collection = Collection::getWithProduct($queryParams, true);
        } else {
            $this->collection = [];
        }

        $this->colors = Colors::getWithProduct($queryParams, true) + Colors::getWithItalianProduct($queryParams, true);

        //$this->priceRange = Product::getPriceRange($queryParams, true);

        $this->diameterRange = [];
        $this->widthRange = [];
        $this->lengthRange = [];
        $this->heightRange = [];
        $this->apportionmentRange = [];

        /** Countries list */

        $countries = [];

        foreach ($this->countries as $key => $obj) {
            $params = $this->catalogFilterParams;

            if (
                !empty($params[$keys['country']]) &&
                in_array($obj['alias'], $params[$keys['country']])
            ) {
                $checked = 1;
                $params[$keys['country']] = '';
            } else {
                $checked = 0;
                $params[$keys['country']] = $obj['alias'];
            }

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $countries[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        /** CATEGORY LIST */

        $category = [];

        foreach ($this->category as $key => $obj) {
            $params = $this->catalogFilterParams;

            $alias = $obj[Yii::$app->languages->getDomainAlias()];

            if (!empty($params[$keys['category']]) && in_array($alias, $params[$keys['category']])) {
                $checked = 1;
                $params[$keys['category']] = '';
            } else {
                $checked = 0;
                $params[$keys['category']] = $alias;
            }

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $category[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'image_link' => $obj['image_link'],
                'image_link2' => $obj['image_link2'],
                'image_link3' => $obj['image_link3'],
            );
        }

        /** TYPE LIST */

        $types = [];

        foreach ($this->types as $key => $obj) {
            $params = $this->catalogFilterParams;

            $alias = $obj[Yii::$app->languages->getDomainAlias()];

            if (!empty($params[$keys['type']]) && in_array($alias, $params[$keys['type']])) {
                $checked = 1;
                $params[$keys['type']] = array_diff($params[$keys['type']], [$alias]);
            } else {
                $checked = 0;
                $params[$keys['type']][] = $alias;
            }

            // sort value

            array_multisort($params[$keys['type']], SORT_ASC, $params[$keys['type']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $types[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        /** SubTypes LIST */

        $subtypes = [];

        foreach ($this->subtypes as $key => $obj) {
            $params = $this->catalogFilterParams;

            if (!empty($params[$keys['subtypes']]) && in_array($obj['alias'], $params[$keys['subtypes']])) {
                $checked = 1;
                $params[$keys['subtypes']] = array_diff($params[$keys['subtypes']], [$obj['alias']]);
            } else {
                $checked = 0;
                $params[$keys['subtypes']][] = $obj['alias'];
            }

            // sort value

            array_multisort($params[$keys['subtypes']], SORT_ASC, $params[$keys['subtypes']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $subtypes[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        /** STYLE LIST */

        $style = [];

        foreach ($this->style as $key => $obj) {
            $params = $this->catalogFilterParams;

            $alias = $obj[Yii::$app->languages->getDomainAlias()];

            if (!empty($params[$keys['style']]) && in_array($alias, $params[$keys['style']])) {
                $checked = 1;
                $params[$keys['style']] = array_diff($params[$keys['style']], [$alias]);
            } else {
                $checked = 0;
                $params[$keys['style']][] = $alias;
            }

            // sort value

            array_multisort($params[$keys['style']], SORT_ASC, $params[$keys['style']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $style[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $alias,
            );
        }

        /** FACTORY LIST */

        $factory = [];

        foreach ($this->factory as $key => $obj) {
            $params = $this->catalogFilterParams;

            if (!empty($params[$keys['factory']]) && in_array($obj['alias'], $params[$keys['factory']])) {
                $checked = 1;
                $params[$keys['factory']] = array_diff($params[$keys['factory']], [$obj['alias']]);
            } else {
                $checked = 0;
                $params[$keys['factory']][] = $obj['alias'];
            }

            // sort value

            array_multisort($params[$keys['factory']], SORT_ASC, $params[$keys['factory']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $factory[$obj['first_letter']][] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
                'first_letter' => $obj['first_letter'],
            );
        }

        // список фабрик для первого показа

        $factory_first_show = [];
        $i = 0;
        $factory_first_show_checked = [];
        foreach ($factory as $letter) {
            foreach ($letter as $val) {
                if ($val['checked']) {
                    $factory_first_show_checked[] = $val;
                } elseif ($i < 5) {
                    $factory_first_show[] = $val;
                    ++$i;
                }
            }
        }
        $factory_first_show = array_merge($factory_first_show_checked, $factory_first_show);

        if (count($factory_first_show_checked) > 5) {
            $factory_first_show = array_slice($factory_first_show, 0, count($factory_first_show_checked) + 1);
        } else {
            $factory_first_show = array_slice($factory_first_show, 0, 5);
        }

        /** COLLECTION LIST */

        $collection = [];

        foreach ($this->collection as $key => $obj) {
            $params = $this->catalogFilterParams;

            if (!empty($params[$keys['collection']]) && in_array($obj['id'], $params[$keys['collection']])) {
                $checked = 1;
                $params[$keys['collection']] = array_diff($params[$keys['collection']], [$obj['id']]);
            } else {
                $checked = 0;
                $params[$keys['collection']][] = $obj['id'];
            }

            // sort value

            array_multisort($params[$keys['collection']], SORT_ASC, $params[$keys['collection']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $collection[$key] = [
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['title'],
                'count' => $obj['count'],
                'alias' => $obj['id']
            ];
        }

        /** COLORS LIST */

        $colors = [];

        foreach ($this->colors as $key => $obj) {
            $params = $this->catalogFilterParams;

            if (!empty($params[$keys['colors']]) && in_array($obj['alias'], $params[$keys['colors']])) {
                $checked = 1;
                $params[$keys['colors']] = array_diff($params[$keys['colors']], [$obj['alias']]);
            } else {
                $checked = 0;
                $params[$keys['colors']][] = $obj['alias'];
            }

            // sort value

            array_multisort($params[$keys['colors']], SORT_ASC, $params[$keys['colors']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $colors[$key] = [
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
                'color_code' => $obj['color_code'],
            ];
        }

        /** Price range */

        $priceRange = [];

        if ($this->priceRange) {
            // min
            if ($this->priceRange['min']) {
                $priceRange['min'] = [
                    'current' => !empty($params[$keys['price']])
                        ? $params[$keys['price']][0]
                        : $this->priceRange['min'],
                    'default' => $this->priceRange['min'],
                ];
            }

            // max
            if ($this->priceRange['max']) {
                $priceRange['max'] = [
                    'current' => !empty($params[$keys['price']])
                        ? $params[$keys['price']][1]
                        : $this->priceRange['max'],
                    'default' => $this->priceRange['max'],
                ];
            }

            if ($priceRange && $priceRange['min']['default'] != $priceRange['max']['default']) {
                $params = $this->catalogFilterParams;

                // calculate
                if (isset($params[$keys['price']]) && $params[$keys['price']][2] == Yii::$app->currency->code) {
                    $priceRange['min']['default'] = Yii::$app->currency->getValue($priceRange['min']['default'], 'EUR', '');
                    $priceRange['max']['default'] = Yii::$app->currency->getValue($priceRange['max']['default'], 'EUR', '');
                } else {
                    $priceRange['min']['current'] = Yii::$app->currency->getValue($priceRange['min']['current'], 'EUR', '');
                    $priceRange['max']['current'] = Yii::$app->currency->getValue($priceRange['max']['current'], 'EUR', '');
                    $priceRange['min']['default'] = Yii::$app->currency->getValue($priceRange['min']['default'], 'EUR', '');
                    $priceRange['max']['default'] = Yii::$app->currency->getValue($priceRange['max']['default'], 'EUR', '');
                }

                $params[$keys['price']] = ['{priceMin}', '{priceMax}', Yii::$app->currency->code];
                $priceRange['link'] = Yii::$app->catalogFilter->createUrl($params, [$this->route]);
            }

        }


        $sizesParams = $this->catalogFilterParams;

        /** Diameter range */

        $diameterRange = [];

        if ($this->diameterRange) {
            $params = $this->catalogFilterParams;

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
            $params = $this->catalogFilterParams;

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
            $params = $this->catalogFilterParams;

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
            $params = $this->catalogFilterParams;

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
            $params = $this->catalogFilterParams;

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
            'keys' => $keys,
            'filterParams' => $this->catalogFilterParams,
            'route' => $this->route,
            'countries' => $countries,
            'category' => $category,
            'types' => $types,
            'subtypes' => $subtypes,
            'style' => $style,
            'factory' => $factory,
            'collection' => $collection,
            'colors' => $colors,
            'factory_first_show' => $factory_first_show,
            'diameterRange' => $diameterRange,
            'widthRange' => $widthRange,
            'lengthRange' => $lengthRange,
            'heightRange' => $heightRange,
            'apportionmentRange' => $apportionmentRange,
            'sizesLink' => $sizesLink,
            'priceRange' => $priceRange,
            'filter' => $this->catalogFilterParams
        ]);
    }
}
