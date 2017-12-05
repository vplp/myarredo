<?php
namespace backend\modules\sys\modules\messages\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\sys\modules\messages\models\{
    Messages as MessagesModel, MessagesLang
};
use backend\modules\sys\modules\messages\Messages as MessagesModule;

/**
 * Class Messages
 *
 * @package backend\modules\sys\modules\messages\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Messages extends MessagesModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'title', 'arraykey'], 'string', 'max' => 1024],
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
        /** @var MessagesModule $module */
        $module = Yii::$app->getModule('sys/messages');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        if (!empty(Yii::$app->getRequest()->get('group_id'))) {
            $query->andWhere(['group_id' => Yii::$app->getRequest()->get('group_id') ?? '']);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere(
            [
                'group_id' => $this->group_id,
            ]
        );

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'arraykey', $this->arraykey]);

        $query->andFilterWhere(['like', MessagesLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MessagesModel::find()->joinWith(['lang']);
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = MessagesModel::find()->joinWith(['lang']);
        return $this->baseSearch($query, $params);
    }
}
