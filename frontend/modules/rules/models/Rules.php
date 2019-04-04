<?php

namespace frontend\modules\rules\models;

use yii\helpers\Url;

/**
 * Class Rules
 *
 * @package frontend\modules\rules\models
 */
class Rules extends \common\modules\rules\models\Rules
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/rules/rules/view', 'id' => $this->id]);
    }
}
