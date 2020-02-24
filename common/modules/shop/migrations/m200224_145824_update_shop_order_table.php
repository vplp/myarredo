<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m200224_145824_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

    /**
     * table name
     * @var string
     */
    public $tableCity = '{{%location_city}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'country_id', $this->integer(11)->notNull()->defaultValue(0)->after('customer_id'));
        $this->createIndex('country_id', $this->table, 'country_id');

        $rows = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($rows as $row) {
            $city = \common\modules\location\models\City::findOne([
                'id' => $row['city_id']
            ]);

            if ($city != null) {
                $connection = Yii::$app->db;
                $connection->createCommand()
                    ->update(
                        $this->table,
                        [
                            'country_id' => $city['country_id']
                        ],
                        'id = ' . $row['id']
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
        $this->dropIndex('country_id', $this->table);
        $this->dropColumn($this->table, 'country_id');
    }
}
