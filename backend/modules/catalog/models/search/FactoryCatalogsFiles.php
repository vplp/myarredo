<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\models\{
    FactoryCatalogsFiles as FactoryCatalogsFilesModel
};

/**
 * Class FactoryCatalogsFiles
 *
 * @package backend\modules\catalog\models\search
 */
class FactoryCatalogsFiles extends FactoryCatalogsFilesModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['factory_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['file_type'], 'in', 'range' => [1, 2]],
        ];
    }

    /**
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
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.factory_id' => $this->factory_id
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FactoryCatalogsFilesModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FactoryCatalogsFilesModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
