<?php

namespace backend\modules\configs\models;

use Yii;
//
use common\modules\configs\models\Language as CommonLanguageModel;

class Language extends CommonLanguageModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['img_flag'], 'string', 'max' => 225],
            [['alias', 'local', 'label'], 'required'],
            [['published', 'default'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
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
        if ($this->default == 1) {
            //для того чтобы дефолтный был один язык
            self::getDb()->createCommand()->update('fv_languages', ['default' => 0], 'alias <> \'' . $this->alias . '\'')->execute();

        }
        return parent::beforeSave($insert);
    }
}
