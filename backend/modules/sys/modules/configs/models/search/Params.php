<?php
namespace backend\modules\sys\modules\configs\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use  backend\modules\sys\modules\configs\Configs as ConfigsModule;
use  backend\modules\sys\modules\configs\models\{
    Params as ParamsModel, ParamsLang
};

/**
 * Class Params
 *
 * @package backend\modules\sys\modules\configs\models\search
 */
class Params extends ParamsModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'string', 'max' => 255],
            [['group_id'], 'integer'],
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
        /** @var ConfigsModule $module */
        $module = Yii::$app->getModule('sys');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['=', 'published', $this->published])
            ->andFilterWhere(['like', 'group_id', $this->group_id]);
        //
        $query->andFilterWhere(['like', ParamsLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ParamsModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ParamsModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
