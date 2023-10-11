<?php

namespace frontend\modules\sys\models;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\sys\Sys;

class Language extends \common\modules\sys\models\Language
{
    /**
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'local', 'alias');
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
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function getLanguages(): array
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBase()->asArray()->all();
        }, 60 * 60);

        return $result;
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function getCurrent(): array
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBase()->andWhere(['local' => \Yii::$app->language])->asArray()->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAllByLocate()
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBase()->indexBy('local')->asArray()->all();
        }, 60 * 60);

        return $result;
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
