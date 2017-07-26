<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * Class Composition
 *
 * @property CompositionLang $lang
 *
 * @package common\modules\catalog\models
 */
class Composition extends Product
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->andWhere(['is_composition' => '1'])
            ->orderBy('updated_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CompositionLang::class, ['rid' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getCompositionImage()
    {
        $module = Yii::$app->getModule('catalog');
        $path = $module->getCompositionUploadPath();
        $url = $module->getCompositionUploadUrl();
        $image = null;
        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }
        return $image;
    }

}
