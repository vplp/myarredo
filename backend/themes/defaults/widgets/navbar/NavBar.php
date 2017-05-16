<?php
namespace backend\themes\defaults\widgets\navbar;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};
use yii\i18n\PhpMessageSource;
//
use backend\themes\defaults\widgets\menu\Menu;

/**
 * Class NavBar
 *
 * @package backend\themes\defaults\widgets\navbar
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class NavBar extends \yii\bootstrap\NavBar
{

    public $name = 'navbar';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * Registers translations
     */
    public function registerTranslations()
    {

        Yii::$app->i18n->translations[$this->name] = [
            'class' => PhpMessageSource::class,
            'basePath' => $this->translationsBasePath,
            'fileMap' => [
                $this->name => 'navbar.php',
            ],
        ];

    }

    /**
     * @var array
     */
    public $options = [
        'class' => 'navbar-default navbar-static-side',
        'role' => 'navigation'
    ];
    /**
     * @var bool
     */
    public $renderInnerContainer = true;
    /**
     * @var array
     */
    public $innerContainerOptions = [
        'class' => 'sidebar-collapse'
    ];
    /**
     * @var array
     */
    public $containerOptions = [
        'tag' => 'ul',
        'id' => 'side-menu'
    ];

    /**
     * Assets bundle
     * @var string
     */
    public $bundle;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        $this->registerTranslations();
        $this->clientOptions = false;
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'nav');
        echo Html::beginTag($tag, $options);
        echo Html::beginTag('div', $this->innerContainerOptions);
        Html::addCssClass($this->containerOptions, ['nav' => 'nav', 'metismenu' => 'metismenu']);
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::beginTag($tag, $options);
    }

    public function run()
    {
        echo $this->render('parts/_navbarHeader', ['bundle' => $this->bundle]);
        echo Menu::widget([
            'items' => $this->menuItems(),
        ]);
        parent::run();
    }

    /**
     * @return array
     */
    public function menuItems()
    {
        return [
            // STRUCTURE
            [
                'label' => '<i class="fa fa-sitemap"></i><span class="nav-label">' . Yii::t('navbar',
                        'Structure') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => '<i class="fa fa-tasks"></i><span class="nav-label">' . Yii::t('navbar',
                                'Menu') . '</span>',
                        'url' => ['/menu/menu/list'],
                    ],
                    [
                        'label' => '<i class="fa fa-file-text"></i> <span class="nav-label">' . Yii::t('navbar',
                                'Pages') . '</span>',
                        'url' => ['/page/page/list']
                    ],
                ]
            ],
            // NEWS
            [
                'label' => '<i class="fa fa-newspaper-o"></i><span class="nav-label">' . Yii::t('navbar',
                        'News') . '</span><span class="fa arrow"></span>',
                'url' => ['/news/article/list'],
            ],
            // CORRESPONDENCE
//            [
//                'label' => '<i class="fa fa-newspaper-o"></i><span class="nav-label">' . Yii::t('navbar',
//                        'Correspondence') . '</span><span class="fa arrow"></span>',
//                'url' => ['/correspondence/correspondence/list'],
//            ],
            //SEO
            [
                'label' => '<i class="fa fa-sitemap"></i><span class="nav-label">' . Yii::t('seo',
                        'Seo') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => '<i class="fa fa-tasks"></i><span class="nav-label">Robots.txt</span>',
                        'url' => ['/seo/robots/update'],
                    ],
                    [
                        'label' => '<i class="fa fa-tasks"></i><span class="nav-label">Direct Link</span>',
                        'url' => ['/seo/directlink/directlink/list'],
                    ],
                    [
                        'label' => '<i class="fa fa-tasks"></i><span class="nav-label">Base Info</span>',
                        'url' => ['/seo/info/info/list'],
                    ],
                ]
            ],
            // USER
            [
                'label' => '<i class="fa fa-users"></i><span class="nav-label">' . Yii::t('navbar',
                        'Users') . '</span> <span class="fa arrow"></span></a>',
                'url' => ['/user/user/list']
            ],
            // LOCATION
            [
                'label' => '<i class="fa fa-map-marker"></i><span class="nav-label">' . Yii::t('navbar',
                        'Location') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => Yii::t('navbar', 'Country'),
                        'url' => ['/location/country/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'City'),
                        'url' => ['/location/city/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Currency'),
                        'url' => ['/location/currency/list']
                    ],
                ],
            ],
            // POLLS
            [
                'label' => '<i class="fa fa-users"></i><span class="nav-label">' . Yii::t('navbar',
                        'Polls') . '</span> <span class="fa arrow"></span></a>',
                'url' => ['/polls/poll/list']
            ],
            // SYSTEM
            [
                'label' => '<i class="fa fa-map-marker"></i><span class="nav-label">' . Yii::t('navbar',
                        'System') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => Yii::t('navbar', 'Configs'),
                        'url' => ['/sys/configs/params/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Growl'),
                        'url' => ['/sys/growl/growl/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Cron'),
                        'url' => ['/sys/crontab/job/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Role of User'),
                        'url' => ['/sys/user/role/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Messages'),
                        'url' => ['/sys/messages/file/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Log'),
                        'url' => ['/sys/logbook/logbook/list']
                    ],
//                    [
//                        'label' => Yii::t('navbar', 'Mail'),
//                        'url' => ['/sys/mail/message/list']
//                    ],
                ],
            ],
            // SHOP
            [
                'label' => '<i class="fa fa-map-marker"></i><span class="nav-label">' . Yii::t('navbar',
                        'Shop') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => Yii::t('navbar', 'Delivery Methods'),
                        'url' => ['/shop/delivery-methods/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Payment Methods'),
                        'url' => ['/shop/payment-methods/list']
                    ],
                    [
                        'label' => Yii::t('navbar', 'Orders'),
                        'url' => ['/shop/order/list']
                    ],

                ],
            ],
        ];
    }
}
