<?php

namespace frontend\modules\catalog\models;


use yii\elasticsearch\ActiveDataProvider;
use yii\elasticsearch\Query;
use yii\elasticsearch\QueryBuilder;

/**
 * ArticlesSearch represents the model behind the search form about `app\models\Articles`.
 */
class Search extends Elastic
{
    public function Searches($value)
    {
        $searchs = $value['search'];

        $query = new Query();

        $db = Elastic::getDb();

        $queryBuilder = new QueryBuilder($db);

        $match = ['field' => ['alias' => 'yii']]; //['match' => ['alias' => $searchs]];

        $query->query = $match;

        $build = $queryBuilder->build($query);

        $re = $query->search($db, $build);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $dataProvider;
    }
}