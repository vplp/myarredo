<?php

namespace backend\modules\correspondence\models;

use Yii;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\correspondence\models\Correspondence as CorrModel;

/**
 * Class Correspondence
 *
 * @package backend\modules\correspondence\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Correspondence extends CorrModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Correspondence())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Correspondence())->trash($params);
    }

    public function beforeSave($insert)
    {
        $this->sender_id = Yii::$app->getUser()->id;

        return parent::beforeSave($insert);
    }
}
