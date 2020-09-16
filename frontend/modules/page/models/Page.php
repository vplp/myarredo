<?php

namespace frontend\modules\page\models;

use yii\helpers\Url;
use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Page
 *
 * @package frontend\modules\page\models
 */
class Page extends \common\modules\page\models\Page implements BaseFrontModel
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
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param null $schema
     * @return mixed|string
     */
    public function getUrl($schema = null)
    {
        return Url::toRoute(['/page/page/view', 'alias' => $this->alias], $schema);
    }
}
