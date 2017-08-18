<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models
 */
class Factory extends \common\modules\catalog\models\Factory
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
        return parent::findBase()->enabled()->asArray();
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Factory())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/factory/view', 'alias' => $alias]);
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage(string $image_link)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();
        $image = null;
        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        } else {
            $image = 'http://placehold.it/200x200';
        }
        return $image;
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        return self::findBase()
            ->all();
    }

    public static function getListLetters()
    {
        return parent::findBase()
            ->enabled()
            ->select([self::tableName().'.first_letter'])
            ->groupBy(self::tableName().'.first_letter')
            ->orderBy(self::tableName().'.first_letter')
            ->all();
    }

    public static function getCategory($id)
    {
        $posts = Yii::$app->db_myarredo->createCommand("SELECT
						`t`.`id` AS fid,
						`tp`.`id` AS tid,
						`tp`.`alias` AS alias,
						`tpL`.`title` AS title
					FROM
						`catalog_factory` `t`
							INNER JOIN
						`catalog_factory_lang` `tL` ON (`tL`.`rid` = `t`.`id`)
							AND (`tL`.`lang` = 'ru-RU')
							INNER JOIN
						`catalog_item` `cI` ON (`cI`.`factory_id` = `t`.`id`)
							AND (`cI`.`published` = '1'
							AND `cI`.`deleted` = '0')
							INNER JOIN
						`catalog_item_rel_catalog_group` `catalogGroups_tp` ON (`cI`.`id` = `catalogGroups_tp`.`catalog_item_id`)
							INNER JOIN
						`catalog_group` `tp` ON (`tp`.`id` = `catalogGroups_tp`.`group_id`)
							INNER JOIN
						`catalog_group_lang` `tpL` ON (`tpL`.`rid` = `tp`.`id`)
							AND (`tpL`.`lang` = 'ru-RU')
					WHERE
						(t.id IN ('" . implode("','", $id) . "'))
					GROUP BY `tp`.`id` , `t`.`id`")->queryAll();

        return $posts;
    }
}