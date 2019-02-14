<?php

namespace backend\modules\user;

use Yii;

/**
 * Class User
 *
 * @package backend\modules\user
 */
class User extends \common\modules\user\User
{
    public $username_attribute = 'username';

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'User',
                'icon' => 'fa fa-sitemap',
                'url' => ['/user/user/list'],
                'position' => 5,
            ];
        }

        return $menuItems;
    }
}
