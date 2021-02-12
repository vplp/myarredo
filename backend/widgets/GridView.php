<?php
namespace backend\widgets;

use Yii;
use yii\helpers\{
    Html, Url
};

/**
 * Class GridView
 *
 * @package backend\widgets\GridView
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'table table-striped'];
    public $options = ['class' => 'ibox float-e-margins'];
    public $layout = "{title}\n<div class='ibox-content'><div class='row'>{toolbar}</div><div class='table-responsive'>{items}</div></div>\n{pager}";

    public $title = '';

    public $toolbar = false;

    /**
     * Returns the options for the grid view JS widget.
     * @return array the options
     */
    protected function getClientOptions()
    {
        if (isset($this->filterUrl)) {
            $filterUrl = $this->filterUrl;
        } else {
            $request = Yii::$app->getRequest();
            $baseUrl = $request->getBaseUrl();
            $filterUrl = substr($request->getUrl(), strlen($baseUrl));
        }

        $id = $this->filterRowOptions['id'];
        $filterSelector = "#$id input, #$id select";
        if (isset($this->filterSelector)) {
            $filterSelector .= ', ' . $this->filterSelector;
        }

        return [
            'filterUrl' => Url::toRoute($filterUrl),
            'filterSelector' => $filterSelector,
        ];
    }

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
        $titleRow = Html::beginTag('div', ['class' => 'ibox-title'])
            . Html::tag('div', $this->renderSummary(), ['class' => 'ibox-tools'])
            . Html::endTag('div');
        return $titleRow;
    }

    /**
     * @return string
     */
    public function renderToolbar()
    {
        $content = Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-primary'])
            . Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['trash'], ['class' => 'btn btn-info']);
        //
        $render = Html::tag('div', '', ['class' => 'col-sm-5 m-b-xs'])
            . Html::tag('div', '', ['class' => 'col-sm-5 m-b-xs'])
            . Html::tag('div', $content, ['class' => 'col-sm-2 btn-group btn-group-sm', 'role' => 'group']);

        return isset($toolbar) ? $render : null;
    }
}