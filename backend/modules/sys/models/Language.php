<?php

namespace backend\modules\sys\models;

use common\modules\sys\models\Language as CommonLanguageModel;

/**
 * Class Language
 *
 * @package backend\modules\sys\models
 */
class Language extends CommonLanguageModel
{
    /**
     * @return mixed
     * выводим только те языки, которые опубликованы
     */
    public function getLanguages():array
    {
        return self::findBase()->enabled()->asArray()->all();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Language())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Language())->trash($params);
    }

    /**
     * @param $insert
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function beforeSave($insert)
    {
        if ($this->by_default == 1) {
            self::getDb()->createCommand()->update(self::tableName(), ['by_default' => self::STATUS_KEY_OFF])->execute();
            $this->deleted = self::STATUS_KEY_OFF;
            $this->published = self::STATUS_KEY_ON;
        }
        return parent::beforeSave($insert);
    }
}
