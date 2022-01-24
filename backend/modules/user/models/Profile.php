<?php

namespace backend\modules\user\models;

/**
 * Class Profile
 *
 * @package backend\modules\user\models
 */
class Profile extends \common\modules\user\models\Profile
{
    /**
     * @inheritDoc
     */
    public function afterFind()
    {
        if ($this->selected_languages != '') {
            $this->selected_languages = explode('/', $this->selected_languages);
            $this->selected_languages = array_filter($this->selected_languages, fn($value) => !is_null($value) && $value !== '');
            $this->selected_languages = array_values($this->selected_languages);
        }

        parent::afterFind();
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (is_array($this->selected_languages) && !empty($this->selected_languages)) {
            $this->selected_languages = '/' . implode('/', array_filter($this->selected_languages)) . '/';
        } else {
            $this->selected_languages = '//';
        }

        return parent::beforeSave($insert);
    }

}
