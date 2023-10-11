<?php

namespace frontend\modules\files\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use thread\app\base\models\query\ActiveQuery;
//
use frontend\modules\files\models\Files as FilesModel;
use frontend\modules\files\FilesModule;

/**
 * Class Files
 *
 * @package backend\modules\files\models\search
 */
class Files extends FilesModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }


    /**
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var FilesModule $module */
        $module = Yii::$app->getModule('files');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FilesModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FilesModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
