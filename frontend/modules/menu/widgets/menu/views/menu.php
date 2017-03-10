<?php
use yii\bootstrap\{
    NavBar, Nav
};

/**
 * @var $item frontend\modules\menu\models\MenuItem
 */

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$itm = [];
foreach ($items as $item):
    $itm[] = [
        'label' => $item['lang']['title'],
        'url' => $item->getLink(),
        'linkOptions' => [
            'target' => $item->getTarget()
        ]
    ];
endforeach;

// user

if (Yii::$app->getUser()->isGuest) {
    $itm[] =
        [
            'label' => 'User Actions',
            'url' => '#',
            'items' => [
                [
                    'label' => 'Login',
                    'url' => Yii::$app->getModule('user')->getUrlLogin()
                ],
                [
                    'label' => 'Registration',
                    'url' => Yii::$app->getModule('user')->getUrlRegistration()
                ],
                [
                    'label' => 'Reset password',
                    'url' => Yii::$app->getModule('user')->getUrlRequestResetPassword()
                ],
                [
                    'label' => 'Log out',
                    'url' => Yii::$app->getModule('user')->getUrlLogOut()
                ],
            ]
        ];
} else {
    $itm[] =
        [
            'label' => 'User Actions',
            'url' => '#',
            'items' => [
                [
                    'label' => 'Password change',
                    'url' => Yii::$app->getModule('user')->getUrlPasswordChange()
                ],
                [
                    'label' => 'Profile',
                    'url' => Yii::$app->getModule('user')->getUrlProfile()
                ],
                [
                    'label' => 'Update profile',
                    'url' => Yii::$app->getModule('user')->getUrlUpdateProfile()
                ],
                [
                    'label' => 'Logout',
                    'url' => Yii::$app->getModule('user')->getUrlLogOut()
                ],
            ]
        ];
}

NavBar::begin([
    'brandLabel' => 'Core CMS', // название организации
    'brandUrl' => Yii::$app->homeUrl, // ссылка на главную страницу сайта
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top', // стили главной панели
    ]
]);
echo Nav::widget([
    'items' => $itm,
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();