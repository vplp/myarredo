<?php

namespace backend\modules\user;

/**
 * Class User
 *
 * @package backend\modules\user
 */
class User extends \common\modules\user\User
{
    public $username_attribute = 'username';

    public $menuItems = [
        'name' => 'User',
        'icon' => 'fa fa-sitemap',
        'url' => ['/user/user/list'],
        'position' => 5,
    ];
}
