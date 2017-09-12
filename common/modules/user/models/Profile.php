<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Profile
 *
 * @property string $phone
 *
 * @package common\modules\user\models
 */
class Profile extends \thread\modules\user\models\Profile
{
    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [

            [['phone'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'ownEdit' => ['phone'],
            'basicCreate' => ['phone'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'phone' => Yii::t('app', 'Phone'),
        ]);
    }
}
