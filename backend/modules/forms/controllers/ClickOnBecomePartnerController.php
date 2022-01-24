<?php

namespace backend\modules\forms\controllers;

use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use backend\modules\forms\models\{
    ClickOnBecomePartner, search\ClickOnBecomePartner as SearchClickOnBecomePartner
};

/**
 * Class ClickOnBecomePartnerController
 *
 * @package backend\modules\forms\controllers
 */
class ClickOnBecomePartnerController extends BackendController
{
    public $title = 'Click on become partner';
    public $name = 'Click on become partner';
    public $model = ClickOnBecomePartner::class;
    public $filterModel = SearchClickOnBecomePartner::class;

    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'layout' => 'list-click-on-become-partner'
                ],
                'create' => false,
                'update' => false,
            ]
        );
    }
}
