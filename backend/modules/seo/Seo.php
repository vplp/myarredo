<?php

namespace backend\modules\seo;

use Yii;
use backend\modules\seo\modules\{
    directlink\Directlink, info\Info
};

/**
 * Class Seo
 *
 * @package backend\modules\seo
 */
class Seo extends \common\modules\seo\Seo
{
    public $itemOnPage = 100;

    public function init()
    {
        $this->modules = [
            'info' => [
                'class' => Info::class,
            ],
            'directlink' => [
                'class' => Directlink::class
            ]
        ];

        parent::init();
    }

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'seo'])) {
            $menuItems = [
                'label' => 'SEO',
                'icon' => 'fa-file-text',
                'position' => 10,
                'items' =>
                    [
                        /*[
                            'label' => 'Robots.txt',
                            'position' => 1,
                            'url' => ['/seo/robots/update'],
                        ],*/
                        [
                            'label' => 'Direct Link',
                            'position' => 2,
                            'url' => ['/seo/directlink/directlink/list'],
                        ],
                        [
                            'label' => Yii::t('seo', 'Redirects'),
                            'url' => ['/seo/redirects/list'],
                        ],
                        /*[
                            'label' => 'Base Info',
                            'position' => 2,
                            'url' => ['/seo/info/info/list'],
                        ]*/
                    ]
            ];
        }

        return $menuItems;
    }
}
