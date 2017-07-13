<?php

namespace thread\actions;

use Yii;
use yii\base\{
    Action, Exception
};
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
//
use thread\app\web\Pagination;

/**
 * Class ListQuery
 *
 * @package thread\actions
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 * @usage
 * public function actions() {
 *      return [
 *          ...
 *          'list' => [
 *              'class' => QueryList::class,
 *              'query' => $model::find(),
 *              'recordOnPage' => 10
 *          ],
 *          ...
 *      ];
 * }
 *
 */
class ListQuery extends Action
{
    /**
     * Base layout
     *
     * @var string
     */
    public $layout = '@app/layouts/base';

    /**
     * Base view
     *
     * @var string
     */
    public $view = 'list';

    /**
     * Access Checking
     *
     * @var bool
     */
    public $checkAccess = false;

    /**
     * @var \yii\db\ActiveQuery
     */
    public $query = null;

    /**
     * Number of model per page
     *
     * @var integer
     */
    public $recordOnPage = -1;

    /**
     * Model sort
     *
     * @var string
     */
    public $sort = '';

    /**
     * @var array
     */
    public $pagination = [];

    /**
     * Init action
     *
     * @inheritdoc
     * @throws Exception
     */
    public function init()
    {
        if ($this->query === null) {
            throw new Exception('::Query must be set.');
        }
    }

    /**
     * Run action
     *
     * @return string
     */
    public function run()
    {
        $data = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => $this->getPagination()
        ]);
        $data->query->addOrderBy($this->sort);

        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $this->controller->renderPartial($this->view, [
                'model' => $data->getModels(),
            ]);
        } else {
            $this->controller->layout = $this->layout;
            return $this->controller->render($this->view, [
                'models' => $data->getModels(),
                'pages' => $data->getPagination(),
            ]);
        }
    }

    /**
     * @return array
     */
    public function getPagination()
    {
        return ArrayHelper::merge([
            'class' => Pagination::class,
            'pageSize' => $this->recordOnPage
        ], $this->pagination);
    }
}
