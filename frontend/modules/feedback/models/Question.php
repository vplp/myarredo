<?php

namespace frontend\modules\feedback\models;

use yii\helpers\HtmlPurifier;

/**
 * Class Question
 *
 * @package frontend\modules\feedback\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Question extends \common\modules\feedback\models\Question
{

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'add_feedback' => ['group_id', 'user_name', 'question', 'subject', 'email'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->HtmlPurifier(['user_name', 'question', 'subject']);
        return parent::beforeSave($insert);
    }

    /**
     * @param array $attributes
     */
    public function HtmlPurifier(array $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->{$attribute} = HtmlPurifier::process($this->{$attribute});
        }
    }
}
