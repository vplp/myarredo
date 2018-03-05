<?php

namespace common\modules\user\models;

/**
 * Class User
 *
 * @property Profile $profile
 * @property Group $group
 *
 * @package common\modules\user\models
 */
class User extends \thread\modules\user\models\User
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith([
                'group',
                'group.lang',
                'profile'
            ]);
    }
}
