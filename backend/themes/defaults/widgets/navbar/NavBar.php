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

    public $menuItems = [];

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

        $modules = require(Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'config' . '/modules.php');

        foreach ($modules as $moduleName => $moduleValue) {
            $moduleClass = Yii::$app->getModule($moduleName);

            if (isset($moduleClass->menuItems) && key_exists('items', $moduleClass->menuItems)) {
                $items = [];
                foreach ($moduleClass->menuItems['items'] as $item) {
                    $items[] = [
                        'label' => '<i class="fa '.$item['icon'].'"></i><span class="nav-label">' .
                            Yii::t('navbar', $item['name']) .
                            '</span>',
                        'url' => $item['url'],
                    ];
                }
                $this->menuItems[] = [
                    'label' => '<i class="fa '.$moduleClass->menuItems['icon'].'"></i><span class="nav-label">' .
                        Yii::t('navbar', $moduleClass->menuItems['name']) .
                        '</span>',
                    'items' => $items,
                    'position' => $moduleClass->menuItems['position'],
                ];
            } else if (isset($moduleClass->menuItems)) {
                $this->menuItems[] = [
                    'label' => '<i class="fa '.$moduleClass->menuItems['icon'].'"></i><span class="nav-label">' .
                        Yii::t('navbar', $moduleClass->menuItems['name']) .
                        '</span>',
                    'url' => $moduleClass->menuItems['url'],
                    'position' => $moduleClass->menuItems['position'],
                ];
            }
        }

        usort($this->menuItems, function ($item1, $item2) {
            return $item1['position'] <=> $item2['position'];
        });

        echo Menu::widget([
            'items' => $this->menuItems,
        ]);

        parent::run();
    }
}
