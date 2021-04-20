<?php

namespace backend\modules\banner\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\banner\BannerModule;
use backend\modules\banner\models\{
    BannerItemBackground as BannerItemBackgroundModel, BannerItemLang
};

/**
 * Class BannerItemBackground
 *
 * @property string $title
 * @property integer $city_id
 *
 * @package backend\modules\banner\models\search
 */
class BannerItemBackground extends BannerItemBackgroundModel implements BaseBackendSearchModel
{
    /**
     * @var int
     */
    public $title;

    /**
     * @var string
     */
    public $city_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['id', 'city_id'], 'integer'],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
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
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var BannerModule $module */
        $module = Yii::$app->getModule('banner');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id
        ]);

        if ($this->city_id) {
            $query
                ->innerJoinWith(["cities"])
                ->andFilterWhere(['IN', 'city_id', $this->city_id]);
        }

        $query->andFilterWhere(['=', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', BannerItemLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BannerItemBackgroundModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = BannerItemBackgroundModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
