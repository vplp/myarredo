<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180206_103833_update_catalog_sale_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item}}';

    public $tableProfile = '{{%user_profile}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'country_id',
            $this
                ->integer(11)
                ->unsigned()
                ->notNull()
                ->defaultValue(0)
                ->after('id')
        );

        $this->addColumn(
            $this->table,
            'city_id',
            $this
                ->integer(11)
                ->unsigned()
                ->notNull()
                ->defaultValue(0)
                ->after('country_id')
        );


        /**
         * Update table
         */
        $sale = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($sale as $saleItem) {
            // UPDATE
            $connection = Yii::$app->db;

            $userItem = (new \yii\db\Query())
                ->from($this->tableProfile)
                ->where(['user_id' => $saleItem['user_id']])
                ->one();

            if (!empty($userItem) && $userItem['country_id'] > 0 && $userItem['city_id'] > 0) {
                $connection->createCommand()
                    ->update(
                        $this->table,
                        [
                            'country_id' => $userItem['country_id'],
                            'city_id' => $userItem['city_id']
                        ],
                        'id = ' . $saleItem['id']
                    )
                    ->execute();
            }
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'city_id');
        $this->dropColumn($this->table, 'country_id');
    }
}
