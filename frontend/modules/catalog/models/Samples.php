<?php

namespace frontend\modules\catalog\models;

/**
 * Class Samples
 *
 * @package frontend\modules\catalog\models
 */
class Samples extends \common\modules\catalog\models\Samples
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getSamplesUploadPath();
        $url = $module->getSamplesUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = 'https://img.myarredo.' . DOMAIN . $url . '/' . $this->image_link;
        }

        return $image;
    }
}
