<?php

namespace frontend\components;

use yii\helpers\Html;

/**
 * Class Breadcrumbs
 *
 * @package frontend\components
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @var array
     */
    public $options = ['class' => 'bread-crumbs', "itemscope itemtype" => "http://schema.org/BreadcrumbList"];

    /**
     * @var string
     */
    public $itemTemplate = "<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">{link}</li>\n";

    /**
     * @var string
     */
    public $activeItemTemplate = "<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\" class=\"active\">{link}</li>\n";

    /**
     * @var bool
     */
    public $encodeLabels = false;

    /**
     * @param array $link
     * @param string $template
     * @return string
     */
    protected function renderItem($link, $template)
    {
        if (!array_key_exists('label', $link)) {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        $link['label'] = Html::tag('span', $link['label'], ['itemprop' => "name"]);
        $link['itemprop'] = 'item';

        return parent::renderItem($link, $template);
    }
}
 