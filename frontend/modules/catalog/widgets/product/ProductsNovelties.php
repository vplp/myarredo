<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
//
use frontend\modules\catalog\models\Category;

/**
 * Class ProductsNovelties
 *
 * @property string $view
 * @property string $modelClass
 * @property object $models
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductsNovelties extends Widget
{
    /**
     * @var string
     */
    public $view = 'products_novelties';

    /**
     * @var string
     */
    public $modelClass = null;

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new Exception(__CLASS__ . '::$modelClass must be set.');
        }

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;


        $query = (new $this->modelClass())::findBase()
            ->limit(8)
            ->asArray()
            ->cache(7200);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
        }

        $this->models = $query->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!empty($this->models)) {
            return $this->render(
                $this->view,
                [
                    'products' => $this->models,
                    'modelClass' => $this->modelClass
                ]
            );
        }
    }
}
