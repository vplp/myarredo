<?php

namespace frontend\modules\banner\widgets\banner;

use yii\base\Widget;
use frontend\modules\banner\models\BannerItem;

/**
 * Class BannerList
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
     * @var object
     */
    protected $model = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->model = BannerItem::findBase()->all();
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
