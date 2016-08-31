<?php
namespace backend\modules\polls\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\polls\models\{
    Vote, VoteLang, Poll, search\Vote as filterVoteModel
};

/**
 * Class VoteController
 *
 * @package backend\modules\polls\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class VoteController extends BackendController
{
    public $model = Vote::class;
    public $modelLang = VoteLang::class;
    public $filterModel = filterVoteModel::class;
    public $group = null;
    public $title = 'Votes';
    public $name = 'vote';

    /**
     * Actions
     *
     * @return array
     */
    public function actions()
    {
        $link = function () {
            return Url::to(
                [
                    'list',
                    'group_id' => ($this->group !== null) ? $this->group->id : 0,
                ]
            );
        };

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'layout' => 'list-vote',
                ],
                'trash' => [
                    'layout' => 'list-vote-trash',
                ],
                'create' => [
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'group_id' => $this->group->id
                        ];
                    }
                ],
                'update' => [
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'group_id' => $this->group->id
                        ];
                    }
                ],
                'published' => [
                    'redirect' => $link
                ],
                'intrash' => [
                    'redirect' => $link
                ],
                'outtrash' => [
                    'redirect' => $link
                ],
            ]
        );
    }

    /**
     * Before actions
     *
     * @param $action
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $groupId = Yii::$app->request->get('group_id', null);

        if (in_array($action->id, ['list', 'create', 'update', 'trash'])) {
            if ($groupId === null) {
                throw new \yii\web\NotFoundHttpException;
            }
        }

        if ($groupId !== null) {
            $this->group = Poll::findById($groupId);
        }

        return parent::beforeAction($action);
    }


}
