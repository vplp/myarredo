<?php

namespace frontend\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Class Breadcrumbs
 *
 * @package frontend\components
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $itemTemplate = '
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            {link}
        </li>
    ';

    public $activeItemTemplate = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            {link}
        </li>
    ';

    public $totalLinks = 0;

    public $options = [
        'class' => 'bread-crumbs',
        'itemscope' => true,
        'itemtype' => 'http://schema.org/BreadcrumbList',
    ];

    /**
     * @return string|void
     * @throws InvalidConfigException
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        $links = [];

        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $this->totalLinks += 1;
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        echo Html::tag($this->tag, implode('', $links), $this->options);
    }

    /**
     * @param array $link
     * @param string $template
     * @return string
     * @throws InvalidConfigException
     */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);

        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $span = Html::tag('span', $label, ['itemprop' => 'name']);
            $link = Html::a($span, $link['url'], array_merge(['itemprop' => 'item'], $options));
        } else {
            $link = Html::tag('span', $label, ['itemprop' => 'name']);
        }

        $meta_content = $this->totalLinks + 1;
        $meta = "<meta itemprop=\"position\" content=\"$meta_content\" />";
        $link .= $meta;

        return strtr($template, ['{link}' => $link]);
    }
}
