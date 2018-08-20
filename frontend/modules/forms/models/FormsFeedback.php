<?php

namespace frontend\modules\forms\models;

use yii\helpers\HtmlPurifier;

/**
 * Class FormsFeedback
 *
 * @package frontend\modules\forms\models\form
 */
Class FormsFeedback extends \common\modules\forms\models\FormsFeedback
{
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->HtmlPurifier(['first_name', 'email', 'phone', 'comment']);
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