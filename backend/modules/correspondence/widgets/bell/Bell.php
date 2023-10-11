<?php

namespace backend\modules\correspondence\widgets\bell;

use Yii;
//
use thread\app\base\widgets\Widget;

/**
 * Class Bell
 *
 * @package backend\modules\correspondence\widgets\bell
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Bell extends Widget
{

    public $view = 'bell';

    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, [
        ]);
    }
}