<?php

namespace frontend\modules\user\widgets\menu;

use Yii;
use yii\base\Widget;

/**
 * Class PartnerInfo
 *
 * @package frontend\modules\user\widgets\menu
 */
class UserMenu extends Widget
{
    /**
     * @var string
     */
    public $view = 'user_menu';

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, []);
    }
}
