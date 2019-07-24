<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_sale_item_rel_catalog_type}}`.
 */
class m190723_131759_create_catalog_sale_item_rel_catalog_type_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_sale_item_rel_catalog_type}}';

    /**
     * @var string
     */
    public $tableType = '{{%catalog_type}}';

    /**
     * @var string
     */
    public $tableItem = '{{%catalog_sale_item}}';


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
        $this->createTable($this->tableRel, [
            'type_id' => $this->integer(11)->unsigned()->notNull(),
            'item_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('idx_type_id', $this->tableRel, 'type_id');
        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_type_id_item_id', $this->tableRel, ['type_id', 'item_id'], true);

        $this->addForeignKey(
            'fk-catalog_sale_item_rel_catalog_type_ibfk_1',
            $this->tableRel,
            'type_id',
            $this->tableType,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_sale_item_rel_catalog_type_ibfk_2',
            $this->tableRel,
            'item_id',
            $this->tableItem,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-catalog_sale_item_rel_catalog_type_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_sale_item_rel_catalog_type_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_type_id_item_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);
        $this->dropIndex('idx_type_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
