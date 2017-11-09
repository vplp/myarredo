<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Widget;

/**
 * Class ProductFilter
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductFilter extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_filter';

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

        // CATEGORY LIST

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

            $link = Yii::$app->catalogFilter->createUrl($params);

            $category[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
            );
        }


        // TYPE LIST

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

            $link = Yii::$app->catalogFilter->createUrl($params);

            $types[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        // STYLE LIST

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

            $link = Yii::$app->catalogFilter->createUrl($params);

            $style[$key] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
                'count' => $obj['count'],
                'alias' => $obj['alias'],
            );
        }

        // FACTORY LIST

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

            $link = Yii::$app->catalogFilter->createUrl($params);

            $factory[$obj['first_letter']][] = array(
                'checked' => $checked,
                'link' => $link,
                'title' => $obj['lang']['title'],
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
                if($val['checked']) {
                    $factory_first_show_checked[] = $val;
                } else if ($i < 5) {
                    $factory_first_show[] = $val;
                    ++$i;
                }
            }
        }
        $factory_first_show = array_merge($factory_first_show_checked,$factory_first_show);

        if(count($factory_first_show_checked)>5) {
            $factory_first_show = array_slice($factory_first_show, 0, count($factory_first_show_checked)+1);
        } else {
            $factory_first_show = array_slice($factory_first_show, 0, 5);
        }

        return $this->render($this->view, [
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'factory_first_show' => $factory_first_show,
            'min_max_price' => !empty($this->min_max_price) ? $this->min_max_price : ['maxPrice' => 0, 'minPrice' => 0],
            'filter' => Yii::$app->catalogFilter->params
        ]);
    }
}