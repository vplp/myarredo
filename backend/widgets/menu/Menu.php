<?php
namespace backend\widgets\menu;

use Yii;
use yii\helpers\{
    ArrayHelper, Html, Url
};

/**
 * Class Menu
 * @package backend\widgets\menu
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @var array
     */
    public $items;

    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a class="{class}" href="{url}">{label}</a>';

    /**
     * @var string
     */
    public $labelTemplate = '<a href="#">{label}</a>';

    /**
     * @var string
     */
    public $submenuTemplate = "\n<ul class='nav nav-second-level'>\n{items}\n</ul>\n";

    /**
     * Make parent elements to be active
     * @var bool
     */
    public $activateParents = true;

    /**
     * Render and run widget
     * @return string
     */
    public function run()
    {
        $this->options = [
            'tag' => false,
        ];
        $this->itemOptions = [
            'tag' => 'li',
        ];
        $this->encodeLabels = false;
        parent::run();
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::toRoute($item['url'])),
                '{label}' => $item['label'],
                '{class}' => $item['active'] ? $this->activeCssClass : '',
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
            return strtr($template, [
                '{label}' => $item['label'],
                '{class}' => $item['active'] ? $this->activeCssClass : '',
            ]);
        }
    }

    /**
     * @inheritdoc
     * @param array $items
     * @return string
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }
}
