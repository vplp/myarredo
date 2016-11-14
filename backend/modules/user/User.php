<?php

namespace backend\modules\user;

/**
 * Class User
 *
 * @package backend\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class User extends \common\modules\user\User
{
    public $username_attribute = 'username';

    /**
     * Шлях до каталогу з повідомленнями
     * @var string
     */
    public $translationsBasePath = __DIR__.'/messages';
}
