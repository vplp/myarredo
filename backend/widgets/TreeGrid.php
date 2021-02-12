<?php

namespace backend\widgets;

use yii\helpers\Html;

/**
 * Class TreeGrid
 *
 * @package backend\widgets
 */
class TreeGrid extends \leandrogehlen\treegrid\TreeGrid
{
    public $title = 'Grid title';

    public $toolbar = false;

    /**
     * @param $name
     * @return bool|string
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{title}':
                return $this->renderTitle();
            case '{toolbar}':
                return $this->renderToolbar();
            case '{items}':
                return $this->renderItems();
            case '{pager}':
                return $this->renderPager();
            case '{sorter}':
                return $this->renderSorter();
            default:
                return false;
        }
    }

    /**
     * @return string
     */
    public function renderTitle()
    {
        $titleRow = Html::beginTag('div', ['class' => 'ibox-title']);
        $titleRow .= '<h5>' . $this->title . '</h5>';
        $titleRow .= Html::tag('div', $this->renderSummary(), ['class' => 'ibox-tools']);
        $titleRow .= Html::endTag('div');
        return $titleRow;
    }

    /**
     * @return null|string
     */
    public function renderToolbar()
    {
        $content = Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-primary'])
            . Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['trash'], ['class' => 'btn btn-info']);
        $render = Html::tag('div', '', ['class' => 'col-sm-5 m-b-xs']);
        $render .= Html::tag('div', '', ['class' => 'col-sm-5 m-b-xs']);
        $render .= Html::tag('div', $content, ['class' => 'col-sm-2 btn-group btn-group-sm', 'role' => 'group']);

        return isset($toolbar) ? $render : null;
    }
}