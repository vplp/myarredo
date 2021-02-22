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
    protected $model = [];

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

        $this->model = $query->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        $detect = new Mobile_Detect();

        if (!$detect->isMobile()) {
            $this->view = 'banner_list_mobile';
        }

        return $this->render(
            $this->view,
            [
                'items' => $this->model,
                'type' => $this->type
            ]
        );
    }
}
