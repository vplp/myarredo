<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;

/**
 * Class SaleFilter
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class SaleFilter extends Widget
{
    /**
     * @var string
     */
    public $view = 'sale_filter';

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
    public $category_counts = [];

    /**
     * @var object
     */
    public $types = [];

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
    public $countries = [];

    /**
     * @var object
     */
    public $cities = [];

    /**
     * @var object
     */
    public $min_max_price = [];

    public function init()
    {
        parent::init();

        $this->min_max_price = ['maxPrice' => 0, 'minPrice' => 0];
    }

    /**
     * @return string
     */
    public function run()
    {
        $keys = Yii::$app->catalogFilter->keys;

        /**
         * Category list
         */

        $category = [];

        foreach ($this->category as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (
                !empty($params[$keys['category']]) &&
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
         * Types list
         */

        $types = [];

        foreach ($this->types as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (
                !empty($params[$keys['type']]) &&
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
         * Style list
         */

        $style = [];

        foreach ($this->style as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (
                !empty($params[$keys['style']]) &&
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
         * Factory list
         */

        $factory = [];

        foreach ($this->factory as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (
                !empty($params[$keys['factory']]) &&
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

        /**
         * список фабрик для первого показа
         */

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
         * Countries list
         */

        $countries = [];
        /*
        foreach ($this->countries as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (
                !empty($params[$keys['country']]) &&
                in_array($obj['alias'], $params[$keys['country']])
            ) {
                $checked = 1;
                $params[$keys['country']] = '';
                $params[$keys['city']] = '';
            } else {
                $checked = 0;
                $params[$keys['country']] = $obj['alias'];
                $params[$keys['city']] = '';
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
        */

        /**
         * Cities list
         */

        $cities = [];

        foreach ($this->cities as $key => $obj) {
            $params = Yii::$app->catalogFilter->params;

            if (
                !empty($params[$keys['city']]) &&
                in_array($obj['alias'], $params[$keys['city']])
            ) {
                $checked = 1;
                $params[$keys['city']] = array_diff($params[$keys['city']], [$obj['alias']]);
            } else {
                $checked = 0;
                $params[$keys['city']][] = $obj['alias'];
            }

            // sort value

            array_multisort($params[$keys['city']], SORT_ASC, $params[$keys['city']]);

            $link = Yii::$app->catalogFilter->createUrl($params, [$this->route]);

            $cities[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        return $this->render($this->view, [
            'route' => $this->route,
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'countries' => $countries,
            'cities' => $cities,
            'factory_first_show' => $factory_first_show,
            'min_max_price' => !empty($this->min_max_price) ? $this->min_max_price : ['maxPrice' => 0, 'minPrice' => 0],
            'filter' => Yii::$app->catalogFilter->params
        ]);
    }
}