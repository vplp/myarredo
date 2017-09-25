<?php

namespace backend\modules\sys\modules\mailcarrier\models;

use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector
};
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class MailBox
 *
 * @package backend\modules\sys\modules\mailcarrier\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailBox extends \thread\modules\sys\modules\mailcarrier\models\MailBox implements BaseBackendModel
{
    public $title;

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'alias',
                    self::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias);
                },
            ],
        ]);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\MailBox())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\MailBox())->trash($params);
    }

    /**
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'lang.title');
    }
}
