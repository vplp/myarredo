<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;

/**
 * Class ProductFilter
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class ProductFilter extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_filter';

    /**
     * @var string
     */
    public $route;

    /**
     * @var object
     */
    public $category = [];

    /**
     * @var object
     */
    public $types = [];

    /**
     * @var object
     */
    public $subtypes = [];

    /**
     * @var object
     */
    public $style = [];

    /**
     * @var object
     */
    public $factory = [];

    /**
     * @var object
     */
    public $price_range = ['min' => 0, 'max' => 99];

    /**
     * @var object
     */
    public $colors = [];

    /**
     * @return string
     */
    public function run()
    {
        $keys = Yii::$app->catalogFilter->keys;

        /**
         * CATEGORY LIST
         */

        $category = [];

        foreach ($this->category as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (!empty($params[$keys['category']]) &&
                in_array($obj['alias'], $params[$keys['category']])
            ) {
                $checked = 1;
                $params[$keys['category']] = '';
            } else {
                $checked = 0;
                $params[$keys['category']] = $obj['alias'];
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

        /**
         * TYPE LIST
         */

        $types = [];

        foreach ($this->types as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (!empty($params[$keys['type']]) &&
                in_array($obj['alias'], $params[$keys['type']])
            ) {
                $checked = 1;
                $params[$keys['type']] = array_diff($params[$keys['type']], [$obj['alias']]);
            } else {
                $checked = 0;
                $params[$keys['type']][] = $obj['alias'];
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

        /**
         * SubTypes LIST
         */

        $subtypes = [];

        foreach ($this->subtypes as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (!empty($params[$keys['subtypes']]) &&
                in_array($obj['alias'], $params[$keys['subtypes']])
            ) {
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

        /**
         * STYLE LIST
         */

        $style = [];

        foreach ($this->style as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (!empty($params[$keys['style']]) &&
                in_array($obj['alias'], $params[$keys['style']])
            ) {
                $checked = 1;
                $params[$keys['style']] = array_diff($params[$keys['style']], [$obj['alias']]);
            } else {
                $checked = 0;
                $params[$keys['style']][] = $obj['alias'];
            }

            // sort value

            array_multisort($params[$keys['style']], SORT_ASC, $params[$keys['style']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $style[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        /**
         * FACTORY LIST
         */

        $factory = [];

        foreach ($this->factory as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (!empty($params[$keys['factory']]) &&
                in_array($obj['alias'], $params[$keys['factory']])
            ) {
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

        /**
         * COLORS LIST
         */

        $colors = [];

        foreach ($this->colors as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (!empty($params[$keys['colors']]) &&
                in_array($obj['alias'], $params[$keys['colors']])
            ) {
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

        /**
         * Price range
         */
        $price_range = [];

        // min
        if ($this->price_range['min']) {
            $price_range['min'] = [
                'current' => !empty($params[$keys['price']])
                    ? $params[$keys['price']][0]
                    : $this->price_range['min'],
                'default' => $this->price_range['min'],
            ];
        }

        // max
        if ($this->price_range['max']) {
            $price_range['max'] = [
                'current' => !empty($params[$keys['price']])
                    ? $params[$keys['price']][1]
                    : $this->price_range['max'],
                'default' => $this->price_range['max'],
            ];
        }

        if (!empty($price_range['min']) && !empty($price_range['max'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['price']] = ['{MIN}', '{MAX}'];
            $price_range['link'] = Yii::$app->catalogFilter->createUrl($params, [$this->route]);
        }

        return $this->render($this->view, [
            'route' => $this->route,
            'category' => $category,
            'types' => $types,
            'subtypes' => $subtypes,
            'style' => $style,
            'factory' => $factory,
            'colors' => $colors,
            'factory_first_show' => $factory_first_show,
            'price_range' => $price_range,
            'filter' => Yii::$app->catalogFilter->params
        ]);
    }
}
