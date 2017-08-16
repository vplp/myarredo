<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Composition as CommonCompositionModel;

/**
 * Class Composition
 *
 * @package backend\modules\catalog\models
 */
class Composition extends CommonCompositionModel implements BaseBackendModel
{
    public $parent_id = 0;

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->alias = (Yii::$app->request->post('CompositionLang'))['title'];

        return parent::beforeValidate();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->id) {
            $this->alias = $this->id . ' ' . $this->alias;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Composition())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Composition())->trash($params);
    }
}
