<?php

namespace backend\modules\sys;

use Yii;
use backend\modules\sys\modules\{
    growl\Growl,
    mailcarrier\MailCarrier,
    user\User,
    crontab\Crontab,
    configs\Configs,
    messages\Messages,
    logbook\Logbook,
    translation\Translation
};

/**
 * Class Sys
 *
 * @package backend\modules\sys
 */
class Sys extends \common\modules\sys\Sys
{
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin'])) {
            $menuItems = [
                'name' => 'System',
                'icon' => 'fa-map-marker',
                'position' => 9,
                'items' => [
                    [
                        'name' => 'Translation',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/translation/translation/list'],
                    ],
                    [
                        'name' => 'Params',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/configs/params/list'],
                    ],
                    /*[
                        'name' => 'Growl',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/growl/growl/list'],
                    ],
                    [
                        'name' => 'MailBox',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/mail-carrier/mail-carrier/list'],
                    ],*/
                    [
                        'name' => 'Role of User',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/user/role/list'],
                    ],
                    /*[
                        'name' => 'Messages',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/messages/file/list'],
                    ],
                    [
                        'name' => 'Log',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/logbook/logbook/list'],
                    ],*/
                ]
            ];
        }

        return $menuItems;
    }

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
            ],
            'messages' => [
                'class' => Messages::class,
            ],
            'logbook' => [
                'class' => Logbook::class,
            ],
            'translation' => [
                'class' => Translation::class,
            ],
            'mail-carrier' => [
                'class' => MailCarrier::class,
            ],
        ];
    }
}
