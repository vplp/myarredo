<?php

namespace backend\modules\menu\models;

use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class MenuItem
 *
 * @package backend\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuItem extends \common\modules\menu\models\MenuItem implements BaseBackendModel
{
    public $title;

    /**
     * @var
     */
    private $_external_link, $_permanent_link;

    /**
     * @param $external_link
     */
    public function setExternal_link($external_link)
    {
        $this->_external_link = $external_link;
    }

    /**
     * @return string
     */
    public function getExternal_link()
    {
        return $this->link;
    }

    /**
     * @param $permanent_link
     */
    public function setPermanent_link($permanent_link)
    {
        $this->_permanent_link = $permanent_link;
    }

    /**
     * @return string
     */
    public function getPermanent_link()
    {
        return $this->link;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['permanent_link', 'external_link'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'backend' => [
                'permanent_link',
                'external_link',
            ],
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->link = ($this->link_type == 'permanent') ? $this->_permanent_link : $this->_external_link;
        if ($this->link === null) {
            $this->link = '';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\MenuItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\MenuItem())->trash($params);
    }
}
