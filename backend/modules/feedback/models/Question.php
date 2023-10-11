<?php

namespace backend\modules\feedback\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Question
 *
 * @package backend\modules\feedback\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Question extends \common\modules\feedback\models\Question implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Question())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Question())->trash($params);
    }
}
