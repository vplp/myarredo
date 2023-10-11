<?php

namespace frontend\modules\seo\widgets;

use yii\base\Widget;

/**
 * Class AjaxMetrics
 *
 * @package frontend\modules\seo\widgets
 */
class AjaxMetrics extends Widget
{
    /**
     * @var string
     */
    public $view = 'ajax_metrics';

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view);
    }
}
