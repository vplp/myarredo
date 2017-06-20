<?php

namespace frontend\modules\user\widgets\topBarInfo;

use Yii;
use thread\app\base\widgets\Widget;
//
use frontend\modules\user\models\Profile;

/**
 * Class topBarInfo
 *
 * @package frontend\modules\user\widgets\topBarInfo
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
     *
     */
    public function init()
    {
        $this->model = Yii::$app->getUser();
        if ($this->model !== null) {
            $this->modelIndentity = Yii::$app->getUser()->getIdentity();
            $this->modelProfile = $this->modelIndentity->profile??null;
        }
    }

    /**
     *
     */
    public function run()
    {
        if ($this->model->isGuest) {
            return $this->render('sigin');
        } else {
            return $this->render('info', [
                'yuser' => $this->model,
                'user' => $this->modelIndentity,
                'profile' => $this->modelProfile,
            ]);
        }
    }
}