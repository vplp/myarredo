<?php

namespace frontend\modules\banner\widgets;

use yii\base\Widget;
use frontend\modules\banner\models\BannerItem;

/**
 * Class FactoryBanner
 *
 * @package frontend\modules\banner\widgets
 */
class FactoryBanner extends Widget
{
    /**
     * @var string
     */
    public $view = 'factory_banner';

    /**
     * @var int
     */
    public $factory_id;

    /**
     * @var object
     */
    protected $model = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->model = BannerItem::findByFactoryId($this->factory_id);
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
