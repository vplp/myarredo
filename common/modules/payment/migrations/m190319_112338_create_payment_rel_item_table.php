<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

/**
 * Class m190319_112338_create_payment_rel_item_table
 */
class m190319_112338_create_payment_rel_item_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%payment_rel_item}}';

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
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableRel, [
            'payment_id' => $this->integer(11)->unsigned()->notNull(),
            'item_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_payment_id', $this->tableRel, 'payment_id');
        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_payment_id_item_id', $this->tableRel, ['payment_id', 'item_id'], true);

        $this->addForeignKey(
            'fk-payment_rel_item_ibfk_1',
            $this->tableRel,
            'payment_id',
            $this->table,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $rows = (new \yii\db\Query())
            ->from('{{%catalog_factory_promotion}}')
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;

            $connection->createCommand()
                ->insert(
                    $this->tableRel,
                    [
                        'payment_id' => $row['id'],
                        'item_id' =>  $row['id'],
                    ]
                )
                ->execute();
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-payment_rel_item_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_payment_id_item_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);
        $this->dropIndex('idx_payment_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
