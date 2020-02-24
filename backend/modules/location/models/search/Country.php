<?php

namespace backend\modules\location\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\location\Location as LocationModule;
use backend\modules\location\models\{
    Country as CountryModel, CountryLang
};

/**
 * Class Country
 *
 * @package backend\modules\location\models\search
 */
class Country extends CountryModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array|mixed
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['alpha2'], 'string', 'min' => 2, 'max' => 2],
            [['alpha3'], 'string', 'min' => 3, 'max' => 3],
        ];
    }

    /**
     * @return array|mixed
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return mixed|ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var LocationModule $module */
        $module = Yii::$app->getModule('location');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => $module->itemOnPage
                ]
            ]
        );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'alpha2', $this->alpha2])
            ->andFilterWhere(['like', 'alpha3', $this->alpha3])
            ->andFilterWhere(['=', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', CountryLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     */
    public function search($params)
    {
        $query = CountryModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     */
    public function trash($params)
    {
        $query = CountryModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
