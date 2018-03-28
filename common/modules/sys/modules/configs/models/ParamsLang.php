<?php

namespace common\modules\sys\modules\configs\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class ParamsLang
 *
 * @package common\modules\sys\modules\configs\models
 */
class ParamsLang extends \thread\modules\sys\modules\configs\models\ParamsLang
{
    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['content'], 'required'],
                ['content', 'string'],
                [['content'], 'default', 'value' => ''],
            ]
        );
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'content'],
        ];
    }
}
