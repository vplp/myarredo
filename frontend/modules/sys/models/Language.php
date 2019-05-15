<?php

namespace frontend\modules\sys\models;

use Yii;
//
use frontend\modules\sys\Sys;
use common\modules\sys\models\Language as CommonLanguageModel;
use yii\helpers\ArrayHelper;

class Language extends CommonLanguageModel
{
    /**
     * @return mixed
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->asArray()->all(), 'local', 'label');
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return self::findBase()
            ->asArray()
            ->all();
    }

    /**
     * @return mixed
     */
    public static function getAllByLocate()
    {
        return $data = self::findBase()
            ->indexBy('local')
            ->asArray()
            ->all();
    }

    /**
     * @param string $img_flag
     * @return bool
     */
    public static function isImage($img_flag = '')
    {
        /** @var Sys $module */
        $module = Yii::$app->getModule('sys');

        $path = $module->getFlagUploadPath();

        $image = false;

        if (!empty($img_flag) && is_file($path . '/' . $img_flag)) {
            $image = true;
        }

        return $image;
    }

    /**
     * @param string $img_flag
     * @return null|string
     */
    public static function getImage($img_flag = '')
    {
        /** @var Sys $module */
        $module = Yii::$app->getModule('sys');

        $path = $module->getFlagUploadPath();
        $url = $module->getFlagUploadUrl();

        $image = null;

        if (!empty($img_flag) && is_file($path . '/' . $img_flag)) {
            $image = $url . '/' . $img_flag;
        }

        return $image;
    }
}
