<?php

namespace frontend\modules\feedback\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use frontend\components\BaseController;
use frontend\modules\feedback\models\{
    Group, Question
};

/**
 * Class FeedbackController
 *
 * @package frontend\modules\feedback\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FeedbackController extends BaseController
{
    public $label = "Feedback";
    public $title = "Feedback";
    public $defaultAction = 'index';
    public $layout = "@app/layouts/base";

    public $breadcrumbs = [];

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Contacts'),
            'url' => Url::toRoute(['/feedback/feedback/index'])
        ];

        return $this->render('index', [
            'form' => new Question([
                'scenario' => 'add_feedback'
            ])
        ]);
    }
}
