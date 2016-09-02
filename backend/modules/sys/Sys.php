<?php

namespace backend\modules\sys;

use backend\modules\sys\modules\{
    growl\Growl, user\User
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
            'user' => [
                'class' => User::class,
            ],
            'growl' => [
                'class' => Growl::class,
            ]
        ];
    }
}
