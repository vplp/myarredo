<?php

namespace backend\modules\sys;

use backend\modules\sys\modules\{
    growl\Growl, user\User, crontab\Crontab, configs\Configs
};

/**
 * Class Sys
 *
 * @package backend\modules\sys
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Sys extends \common\modules\sys\Sys
{
    public $itemOnPage = 20;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->modules = [
            'configs' => [
                'class' => Configs::class,
            ],
            'user' => [
                'class' => User::class,
            ],
            'growl' => [
                'class' => Growl::class,
            ],
            'crontab' => [
                'class' => Crontab::class,
            ]
        ];
    }
}
