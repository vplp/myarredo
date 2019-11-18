<?php

namespace frontend\modules\banner\widgets\banner;

use yii\base\Widget;
use frontend\modules\banner\models\BannerItem;

/**
 * Class BannerList
 *
 * @property string $view
 * @property string $type
 * @property object $model
 *
 * @package frontend\modules\banner\widgets\banner
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
     * @var object
     */
    protected $model = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->model = BannerItem::findBase()
            ->andWhere([
                BannerItem::tableName() . '.type' => $this->type
            ])
            ->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'items' => $this->model
            ]
        );
    }
}
