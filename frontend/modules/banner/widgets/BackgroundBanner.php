<?php

namespace frontend\modules\banner\widgets;

use yii\base\Widget;
//
use frontend\modules\banner\models\{
    BannerItemBackground, BannerItemRelCity
};

/**
 * Class BackgroundBanner
 *
 * @property string $view
 * @property string $type
 * @property string $background
 * @property integer $city_id
 * @property object $bannerLeft
 * @property object $bannerRight
 *
 * @package frontend\modules\banner\widgets
 */
class BackgroundBanner extends Widget
{
    /**
     * @var string
     */
    public $view = 'background_banner';

    /**
     * @var string
     */
    public $type = 'background';

    /**
     * @var string
     */
    public $background = '#000000';

    /**
     * @var integer
     */
    public $city_id = 0;

    /**
     * @var object
     */
    protected $bannerLeft = [];

    /**
     * @var object
     */
    protected $bannerRight = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        // Left
        $query = BannerItemBackground::findBase();

        if ($this->city_id) {
            $query
                ->innerJoinWith(["cities"])
                ->andFilterWhere([BannerItemRelCity::tableName() . '.city_id' => $this->city_id]);
        }

        $this->bannerLeft = $query->andWhere([BannerItemBackground::tableName() . '.side' => 'left'])->one();

        // Right
        $query = BannerItemBackground::findBase();

        if ($this->city_id) {
            $query
                ->innerJoinWith(["cities"])
                ->andFilterWhere([BannerItemRelCity::tableName() . '.city_id' => $this->city_id]);
        }

        $this->bannerRight = $query->andWhere([BannerItemBackground::tableName() . '.side' => 'right'])->one();

        if ($this->bannerLeft) {
            $this->background = $this->bannerLeft['background_code'];
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'background' => $this->background,
                'bannerLeft' => $this->bannerLeft,
                'bannerRight' => $this->bannerRight,
            ]
        );
    }
}
