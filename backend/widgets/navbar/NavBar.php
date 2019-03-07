<?php

namespace backend\widgets\navbar;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};
use yii\i18n\PhpMessageSource;
//
use backend\widgets\menu\Menu;

/**
 * Class NavBar
 *
 * @package backend\widgets\navbar
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

        // list modules
        $modules = require(Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'config' . '/modules.php');

        foreach ($modules as $moduleName => $moduleValue) {
            $moduleClass = Yii::$app->getModule($moduleName);

            if (method_exists($moduleClass, 'getMenuItems')) {
                $MenuItems = $moduleClass->getMenuItems();

                // get item 1st level menu
                if (!empty($MenuItems)) {
                    $this->menuItems[$moduleName] = $this->getItem($moduleClass->getMenuItems());
                }

                // get items 2nd level menu
                if (key_exists('items', $MenuItems)) {
                    $items = [];
                    foreach ($MenuItems['items'] as $item) {
                        $items[] = $this->getItem($item);
                    }
                    // set items menu 2nd level and sort them
                    $this->menuItems[$moduleName]['label'] .= '</span><span class="fa arrow"></span>';
                    $this->menuItems[$moduleName]['items'] = $this->sortItems($items);
                }
            }
        }

        // other items menu
        if (!empty($this->otherItems())) {
            foreach ($this->otherItems() as $moduleName => $Item) {
                // get item 1st level menu
                $this->menuItems[$moduleName] = $this->getItem($Item);

                // get items 2nd level menu
                if (key_exists('items', $Item)) {
                    $items = [];
                    foreach ($Item['items'] as $item) {
                        $items[] = $this->getItem($item);
                    }
                    // set items 2nd level menu and sort them
                    $this->menuItems[$moduleName]['items'] = $this->sortItems($items);
                }
            }
        }

        // sort items 1st level menu
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

        $label = Yii::t('navbar', $item['label']);

        $array['label'] = '<i class="fa ' . $icon . '"></i><span class="nav-label">' . $label . '</span>';

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
     * Other items menu
     *
     * @return array
     */
    private function otherItems()
    {
        return [];
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
