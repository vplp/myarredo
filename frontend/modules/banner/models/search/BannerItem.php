<?php

namespace frontend\modules\banner\models\search;

use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use frontend\modules\banner\models\{
    BannerItemLang, BannerItem as BannerItemModel
};

/**
 * Class BannerItem
 *
 * @package frontend\modules\banner\models\search
 */
class BannerItem extends BannerItemModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', BannerItemLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BannerItemModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
