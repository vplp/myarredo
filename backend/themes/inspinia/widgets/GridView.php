<?php
namespace backend\themes\inspinia\widgets;

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: roman
 * Date: 6/30/2016
 * Time: 12:54 PM
 */

class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'table table-striped'];
    public $options = ['class' => 'ibox float-e-margins'];
    public $layout = "{title}\n<div class='ibox-content'><div class='row'>{toolbar}</div><div class='table-responsive'>{items}</div></div>\n{pager}";

    public $title = '';

    public $toolbar = false;

    /**
     * @inheritdoc
     * @param string $name
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
        $title = !empty($this->title) ? \Yii::t('app', $this->title) : $this->view->context->title;
        $titleRow = Html::beginTag('div', ['class' => 'ibox-title']);
        $titleRow .= '<h5>' . $title .'</h5>';
        $titleRow .= Html::tag('div', $this->renderSummary(), ['class' => 'ibox-tools']);
        $titleRow .= Html::endTag('div');
        return $titleRow;
    }

    /**
     * @return string
     */
    public function renderToolbar()
    {
        $content = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'btn btn-primary'])
            . Html::a('<i class="glyphicon glyphicon-trash"></i>', ['trash'], ['class' => 'btn btn-info']);
        $render = Html::tag('div', '', ['class' => 'col-sm-5 m-b-xs']);
        $render .= Html::tag('div', '', ['class' => 'col-sm-5 m-b-xs']);
        $render .= Html::tag('div', $content, ['class' => 'col-sm-2 btn-group btn-group-sm', 'role' => 'group']);

        return isset($toolbar) ? $render : null;
    }
}