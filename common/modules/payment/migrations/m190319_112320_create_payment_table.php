<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

/**
 * Class m190319_112320_create_payment_table
 */
class m190319_112320_create_payment_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%payment}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = PaymentModule::getDb();
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'type' => "enum('factory_promotion','italian_item') NOT NULL DEFAULT 'factory_promotion'",
            'amount' => "decimal(10,2) NOT NULL DEFAULT '0.00'",
            'currency' => "enum('EUR','RUB','USD') NOT NULL DEFAULT 'EUR'",
            'payment_status' => "enum('pending','accepted','success','fail') NOT NULL DEFAULT 'pending'",
            'payment_time' => $this->integer(10)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '1'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0'",
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
        $this->createIndex('type', $this->table, 'type');
        $this->createIndex('payment_status', $this->table, 'payment_status');
        $this->createIndex('payment_time', $this->table, 'payment_time');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');

        /**
         * Update table
         */

        $rows = (new \yii\db\Query())
            ->from('{{%catalog_factory_promotion}}')
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;

            $connection->createCommand()
                ->insert(
                    $this->table,
                    [
                        'id' => $row['id'],
                        'user_id' =>  $row['user_id'],
                        'type' => 'factory_promotion',
                        'amount' => $row['amount'],
                        'currency' => 'RUB',
                        'payment_status' => $row['payment_status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'published' => $row['published'],
                        'deleted' => $row['deleted'],
                    ]
                )
                ->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('user_id', $this->table);
        $this->dropIndex('type', $this->table);
        $this->dropIndex('payment_time', $this->table);
        $this->dropIndex('payment_status', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);

        $this->dropTable($this->table);
    }
}
