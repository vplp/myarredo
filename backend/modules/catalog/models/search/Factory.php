<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\Catalog;
use backend\modules\catalog\models\{
    Factory as FactoryModel, FactoryLang
};

/**
 * Class Factory
 *
 * @package backend\modules\catalog\models\search
 */
class Factory extends FactoryModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'show_for_ru',
                    'show_for_by',
                    'show_for_ua',
                    'show_for_com',
                    'show_for_de',
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['producing_country_id', 'editor_id'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
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
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', self::tableName() . '.editor_id', $this->editor_id]);

        $query->andFilterWhere(['=', self::tableName() . '.producing_country_id', $this->producing_country_id]);
        $query->andFilterWhere(['=', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['=', self::tableName() . '.show_for_ru', $this->show_for_ru]);
        $query->andFilterWhere(['=', self::tableName() . '.show_for_by', $this->show_for_by]);
        $query->andFilterWhere(['=', self::tableName() . '.show_for_ua', $this->show_for_ua]);
        $query->andFilterWhere(['=', self::tableName() . '.show_for_com', $this->show_for_com]);
        $query->andFilterWhere(['=', self::tableName() . '.show_for_de', $this->show_for_de]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FactoryModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchTranslation($params)
    {
        $query = FactoryModel::find()->joinWith(['lang'])->undeleted();

        $query
            ->andWhere([
                'OR',
                ['=', FactoryLang::tableName() . '.mark', '0'],
                //['=', FactoryLang::tableName() . '.title', ''],
                //['=', FactoryLang::tableName() . '.description', '']
            ]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FactoryModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
