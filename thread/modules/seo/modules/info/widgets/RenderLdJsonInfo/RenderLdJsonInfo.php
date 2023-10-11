<?php

namespace thread\modules\seo\modules\info\widgets\RenderLdJsonInfo;

use yii\helpers\ArrayHelper;
//
use yii\base\Widget;
use thread\modules\seo\modules\info\models\{
    Info
};

/**
 * Class RenderLdJsonInfo
 *
 * @package thread\modules\seo\modules\info\widgets\RenderLdJsonInfo
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class RenderLdJsonInfo extends Widget
{

    /**
     * View
     *
     * @var string
     */
    public $view = 'RenderLdJsonInfo';

    public $params = [];

    /**
     * Run run run
     *
     * @return string
     */
    public function init()
    {
        $this->params = ArrayHelper::map(Info::find()->innerJoinWith(['lang'])->all(), 'alias', 'lang.value');
        parent::init();
    }


    /**
     * Run run run
     *
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, ['params' => $this->params]);
    }
}
