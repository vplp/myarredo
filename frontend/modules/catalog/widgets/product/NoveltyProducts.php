<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
use frontend\modules\catalog\models\Category;

/**
 * Class NoveltyProducts
 *
 * @property string $view
 * @property string $modelClass
 * @property string $modelLangClass
 * @property object $models
 *
 * @package frontend\modules\catalog\widgets\product
 */
class NoveltyProducts extends Widget
{
    /**
     * @var string
     */
    public $view = 'novelty_products';

    /**
     * @var string
     */
    public $modelClass = null;

    /**
     * @var string
     */
    public $modelLangClass = null;

    /**
     * @var object
     */
    protected $sliderData = [];

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

        $modelClass = new $this->modelClass();
        $modelLangClass = new $this->modelLangClass();

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $query = $modelClass::findBaseArray()
            ->select([
                $modelClass::tableName() . '.id',
                $modelClass::tableName() . '.alias',
                $modelClass::tableName() . '.image_link',
                $modelClass::tableName() . '.factory_id',
                $modelClass::tableName() . '.price',
                $modelClass::tableName() . '.price_new',
                $modelLangClass::tableName() . '.title',
            ])
            ->limit(8)
            ->cache(7200);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Category::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        $this->models = $query->all();

        foreach ($this->models as $model) {
            $this->sliderData[] = array(
                'href' => $modelClass::getUrl($model['alias']),
                'src' => $modelClass::getImageThumb($model['image_link']),
                'text' => $model['lang']['title'],
                'percent' => $modelClass::getSavingPrice($model) ? $modelClass::getSavingPercentage($model) : '',
            );
        }
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
                    'sliderData' => json_encode($this->sliderData)
                ]
            );
        }
    }
}
