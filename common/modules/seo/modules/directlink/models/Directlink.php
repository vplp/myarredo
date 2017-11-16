<?php

namespace common\modules\seo\modules\directlink\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Directlink
 *
 * @property string $contacts
 *
 * @package common\modules\seo\modules\directlink\models
 */
class Directlink extends \thread\modules\seo\modules\directlink\models\Directlink
{
    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['content'], 'string'],
            [['h1'], 'string', 'max' => 255],
            [['description', 'keywords', 'image_url', 'h1', 'content'], 'default', 'value' => '']
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'backend' => ['h1', 'content'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'h1' => 'H1',
            'content' => Yii::t('app', 'Content'),
        ]);
    }
}
