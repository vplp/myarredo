<?php

namespace backend\modules\sys\modules\logbook\controllers;

use backend\modules\sys\modules\logbook\models\{LogbookByMonth, search\LogbookByMonth as filterModel, Logbook};
use thread\actions\{AttributeSwitch, Create, Update};
use thread\app\base\controllers\BackendController;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class LogbookByMonthController
 *
 * @package backend\modules\sys\modules\logbook\controllers
 */
class LogbookByMonthController extends BackendController
{
    public $model = LogbookByMonth::class;
    public $filterModel = filterModel::class;
    public $title = 'Logbook by month';
    public $name = 'Logbook by month';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => '/base',
            ],
        ]);
    }

    public function actionImport()
    {
        $query = Logbook::find();

        foreach ($query->batch(100) as $models) {
            foreach ($models as $item) {
                if (in_array($item->model_name, ['Product', 'Composition', 'FactoryPricesFiles', 'FactoryCatalogsFiles'])) {
                    Yii::$app->logbookByMonth->send($item->action_method . $item->model_name, $item->updated_at);
                }
            }
        }
    }

}
