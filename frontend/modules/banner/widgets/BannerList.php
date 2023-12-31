<?php

namespace frontend\modules\banner\widgets;

use yii\base\Widget;
use frontend\modules\banner\models\{
    BannerItem, BannerItemRelCity
};
use Mobile_Detect;

/**
 * Class BannerList
 *
 * @property string $view
 * @property string $type
 * @property integer $city_id
 * @property object $model
 *
 * @package frontend\modules\banner\widgets
 */
class BannerList extends Widget
{
    /**
     * @var string
     */
    public $view = 'banner_list';

    /**
     * @var string
     */
    public $type = 'main';

    /**
     * @var integer
     */
    public $city_id = 0;

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $query = BannerItem::findBase()
            ->andWhere([
                BannerItem::tableName() . '.type' => $this->type
            ]);

        if ($this->city_id) {
            $query
                ->innerJoinWith(["cities"])
                ->andFilterWhere([BannerItemRelCity::tableName() . '.city_id' => $this->city_id]);
        }

        $this->models = $query->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        $filterItem = [];

        foreach ($this->models as $model) {
            if ($model['show_filter']) {
                $filterItem = $model;
                continue;
            }
        }

        return $this->render(
            $this->view,
            [
                'items' => $this->models,
                'filterItem' => $filterItem,
                'type' => $this->type
            ]
        );
    }
}
