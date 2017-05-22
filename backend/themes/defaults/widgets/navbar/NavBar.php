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
     * Initializes the widget
     */
    public function init()
    {
        $this->registerTranslations();

        $modules = require(Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'config' . '/modules.php');

        foreach ($modules as $moduleName => $moduleValue) {
            $moduleClass = Yii::$app->getModule($moduleName);

            // get item menu
            if (isset($moduleClass->menuItems)) {
                $this->menuItems[$moduleName] = $this->getItem($moduleClass->menuItems);
            }

            // get items menu
            if (isset($moduleClass->menuItems) && key_exists('items', $moduleClass->menuItems)) {
                $items = [];
                foreach ($moduleClass->menuItems['items'] as $item) {
                    $items[] = $this->getItem($item);
                }
                // set items menu and sort them
                $this->menuItems[$moduleName]['items'] = $this->sortItems($items);
            }
        }

        // sort items menu
        $this->menuItems = $this->sortItems($this->menuItems);
    }

    /**
     * Get item menu
     *
     * @param $item
     * @return array
     */
    private function getItem($item)
    {
        $array = [];

        $icon = $item['icon'] ?? '';
        $name = Yii::t('navbar', $item['name']);

        $array['label'] = '<i class="fa ' . $icon . '"></i><span class="nav-label">' . $name . '</span>';
        if (isset($item['url'])) {
            $array['url'] = $item['url'];
        }
        $array['position'] = $item['position'] ?? 0;

        return $array;
    }

    /**
     * Sort items menu
     *
     * @param $items
     * @return mixed
     */
    private function sortItems($items)
    {
        usort($items, function ($item1, $item2) {
            return $item1['position'] <=> $item2['position'];
        });
        return $items;
    }

    /**
     * Run the widget
     */
    public function run()
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

        echo $this->render('parts/_navbarHeader', ['bundle' => $this->bundle]);

        echo Menu::widget([
            'items' => $this->menuItems,
        ]);

        parent::run();
    }
}
