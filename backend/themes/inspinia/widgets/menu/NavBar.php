<?php
namespace backend\themes\inspinia\widgets\menu;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};

/**
 * Class NavBar
 * @package backend\themes\inspinia\widgets\menu
 */
class NavBar extends \yii\bootstrap\NavBar
{

    public $options = [
        'class' => 'navbar-default navbar-static-side',
        'role' => 'navigation'
    ];

    public $renderInnerContainer = true;

    public $innerContainerOptions = [
        'class' => 'sidebar-collapse'
    ];

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
                'label' => '<i class="fa fa-sitemap"></i><span class="nav-label">' . Yii::t('app',
                        'Structure') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => '<i class="fa fa-tasks"></i><span class="nav-label">' . Yii::t('app',
                                'Menu') . '</span>',
                        'url' => ['/menu/menu/list'],
                    ],
                    [
                        'label' => '<i class="fa fa-file-text"></i> <span class="nav-label">' . Yii::t('app',
                                'Pages') . '</span>',
                        'url' => ['/page/page/list']
                    ],
                ]
            ],
            // NEWS
            [
                'label' => '<i class="fa fa-newspaper-o"></i><span class="nav-label">' . Yii::t('app',
                        'News') . '</span><span class="fa arrow"></span>',
                'url' => ['/news/article/list'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Article'),
                        'url' => ['/news/article/list']
                    ],
                    [
                        'label' => Yii::t('app', 'Groups'),
                        'url' => ['/news/group/list']
                    ],
                ],
            ],
            //SEO
            [
                'label' => '<i class="fa fa-users"></i><span class="nav-label">' . Yii::t('app',
                        'Seo') . '</span> <span class="fa arrow"></span></a>',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Seo'),
                        'url' => ['/seo/seo/list']
                    ],
                    [
                        'label' => Yii::t('app', 'Robots.txt'),
                        'url' => ['/seo/robots/update']
                    ],
                ],
            ],

            // USER
            [
                'label' => '<i class="fa fa-users"></i><span class="nav-label">' . Yii::t('app',
                        'User') . '</span> <span class="fa arrow"></span></a>',
                'items' => [
                    [
                        'label' => Yii::t('app', 'User list'),
                        'url' => ['/user/user/list'],
                    ],
                    [
                        'label' => Yii::t('app', 'Groups'),
                        'url' => ['/user/group/list'],
                    ],
                ],
            ],
            // LOCATION
            [
                'label' => '<i class="fa fa-map-marker"></i><span class="nav-label">' . Yii::t('app',
                        'Location') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Country'),
                        'url' => ['/location/country/list']
                    ],
                    [
                        'label' => Yii::t('app', 'City'),
                        'url' => ['/location/city/list']
                    ],
                    [
                        'label' => Yii::t('app', 'Currency'),
                        'url' => ['/location/currency/list']
                    ],
                ],
            ],
            // CONFIGS
            [
                'label' => '<i class="fa fa-map-marker"></i><span class="nav-label">' . Yii::t('app',
                        'Configs') . '</span><span class="fa arrow"></span>',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Params'),
                        'url' => ['/configs/params/list']
                    ],
                ],
            ],
        ];
    }
}
