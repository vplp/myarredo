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
    public $itemOnPage = 100;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'System',
                'icon' => 'fa-map-marker',
                'position' => 9,
                'items' => [
                    [
                        'label' => 'Translation',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/translation/translation/list'],
                    ],
                    [
                        'label' => 'Params',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/configs/params/list'],
                    ],
                    /*[
                        'label' => 'Growl',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/growl/growl/list'],
                    ],
                    [
                        'label' => 'MailBox',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/mail-carrier/mail-carrier/list'],
                    ],*/
                    [
                        'label' => 'Role of User',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/user/role/list'],
                    ],
                    [
                        'label' => 'Language',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/language/list'],
                    ],
                    [
                        'label' => 'Logbook',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/logbook/logbook/list'],
                    ],
                    [
                        'label' => 'Logbook by month',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/logbook/logbook-by-month/list'],
                    ],
                    /*[
                        'label' => 'Messages',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/messages/file/list'],
                    ],
                    [
                        'label' => 'LogbookAuth',
                        'icon' => 'fa-tasks',
                        'url' => ['/sys/logbook/logbook-auth/list'],
                    ],
                    */
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
