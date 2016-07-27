<?php
namespace backend\themes\inspinia\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Tabs extends \yii\bootstrap\Tabs
{
    /**
     * @var string
     */
    public $position = 'left';


    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('tab');

        echo Html::beginTag('div', ['class' => 'tabs-container', 'style' => ['margin-bottom' => '15px']]);
        echo Html::beginTag('div', ['class' => 'tabs-'.$this->position]);

        echo $this->renderItems();

        echo Html::endTag('div');
        echo Html::endTag('div');
    }

    /**
     * Renders tab items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab() && !empty($this->items)) {
            $this->items[0]['active'] = true;
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));

            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

            Html::addCssClass($options, ['widget' => 'tab-pane']);
            if (ArrayHelper::remove($item, 'active')) {
                Html::addCssClass($options, 'active');
                Html::addCssClass($headerOptions, 'active');
            }

            if (isset($item['url'])) {
                $header = Html::a($label, $item['url'], $linkOptions);
            } else {
                if (!isset($linkOptions['data-toggle'])) {
                    $linkOptions['data-toggle'] = 'tab';
                }
                $header = Html::a($label, '#' . $options['id'], $linkOptions);
            }

            if ($this->renderTabContent && isset($item['content'])) {
                $tag = ArrayHelper::remove($options, 'tag', 'div');
                $item['content'] = Html::tag('div', $item['content'], ['class' => 'panel-body']);
                $panes[] = Html::tag($tag, isset($item['content']) ? $item['content'] : '', $options);
            }


            $headers[] = Html::tag('li', $header, $headerOptions);
        }
//        var_dump($panes);
        return Html::tag('ul', implode("\n", $headers), $this->options)
            . ($this->renderTabContent ? "\n" . Html::tag('div', implode("\n", $panes), ['class' => 'tab-content']) : '');
    }
}
