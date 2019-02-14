<?php

namespace frontend\modules\user\widgets\topBarInfo;

use Yii;
use thread\app\base\widgets\Widget;

/**
 * Class topBarInfo
 *
 * @package frontend\modules\user\widgets\topBarInfo
 */
class topBarInfo extends Widget
{
    /**
     * @var string
     */
    public $view = 'index';

    /**
     * @var string
     */
    public $name = 'topBarInfo';

    /**
     * @var null
     */
    protected $model = null;

    /**
     * @var null Profile
     */
    protected $modelIndentity = null;

    /**
     * @var null
     */
    protected $modelProfile = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->model = Yii::$app->getUser();
        if ($this->model != null) {
            $this->modelIndentity = Yii::$app->user->identity;
            $this->modelProfile = $this->modelIndentity->profile ?? null;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if ($this->model->isGuest) {
            return $this->render('sign_in');
        } else {
            return $this->render('info', [
                'user' => $this->modelIndentity,
                'profile' => $this->modelProfile,
            ]);
        }
    }
}