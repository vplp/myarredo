<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
use frontend\modules\catalog\models\Category;

/**
 * Class ProductsNovelties
 *
 * @property string $view
 * @property string $modelPromotionItemClass
 * @property string $modelPromotionItemLangClass
 * @property string $modelClass
 * @property string $modelLangClass
 * @property object $models
 * @property object $modelsPromotions
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
    public $modelPromotionItemClass = null;

    /**
     * @var string
     */
    public $modelPromotionItemLangClass = null;

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
    public $sliderData = [];

    /**
     * @var object
     */
    protected $models = [];

    /**
     * @var object
     */
    protected $modelsPromotions = [];

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
                $modelClass::tableName() . '.alias_en',
                $modelClass::tableName() . '.alias_it',
                $modelClass::tableName() . '.alias_de',
                $modelClass::tableName() . '.image_link',
                $modelClass::tableName() . '.factory_id',
                $modelClass::tableName() . '.bestseller',
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

        if ($this->modelPromotionItemClass != null && $this->modelPromotionItemLangClass != null) {
            $modelPromotionItemClass = new $this->modelPromotionItemClass();
            $modelPromotionItemLangClass = new $this->modelPromotionItemLangClass();

            $query = $modelPromotionItemClass::findBaseArray()
                ->select([
                    $modelPromotionItemClass::tableName() . '.id',
                    $modelPromotionItemClass::tableName() . '.alias',
                    $modelPromotionItemClass::tableName() . '.image_link',
                    $modelPromotionItemClass::tableName() . '.factory_id',
                    $modelPromotionItemClass::tableName() . '.bestseller',
                    $modelPromotionItemClass::tableName() . '.price',
                    $modelPromotionItemLangClass::tableName() . '.title',
                ])
                ->limit(8);

            if (!isset($params[$keys['category']])) {
                $query->andWhere(['>', $modelPromotionItemClass::tableName() . '.time_vip_promotion_in_catalog', 0]);
                $query->andWhere('(FROM_UNIXTIME(' . $modelPromotionItemClass::tableName() . '.time_vip_promotion_in_catalog) + interval :days day) >= now()', [
                    ':days' => 10
                ]);
            } else {
                $query->andWhere(['>', $modelPromotionItemClass::tableName() . '.time_vip_promotion_in_category', 0]);
                $query->andWhere('(FROM_UNIXTIME(' . $modelPromotionItemClass::tableName() . '.time_vip_promotion_in_category) + interval :days day) >= now()', [
                    ':days' => 10
                ]);
            }

            $this->modelsPromotions = $query->all();
        }

        // Ready data for front
        foreach ($this->modelsPromotions as $model) {
            $this->sliderData[] = array(
                'href' => $modelPromotionItemClass::getUrl($model[Yii::$app->languages->getDomainAlias()]),
                'src' => $modelPromotionItemClass::getImageThumb($model['image_link']),
                'text' => $model['lang']['title'],
                'percent' => 'vip',
                'bestseller' => 0
            );
        }

        foreach ($this->models as $model) {
            $this->sliderData[] = array(
                'href' => $modelClass::getUrl($model[Yii::$app->languages->getDomainAlias()]),
                'src' => $modelClass::getImageThumb($model['image_link']),
                'text' => $model['lang']['title'],
                'percent' => $modelClass::getSavingPrice($model) ? $modelClass::getSavingPercentage($model) : '',
                'bestseller' => $model['bestseller'] ? 1 : 0
            );
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!empty($this->models) || !empty($this->modelsPromotions)) {
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
