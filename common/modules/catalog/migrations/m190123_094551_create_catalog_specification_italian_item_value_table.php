<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `catalog_specification_italian_item_value`.
 */
class m190123_094551_create_catalog_specification_italian_item_value_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_specification_italian_item_value}}';

    /**
     * @var string
     */
    public $tableSpecification = '{{%catalog_specification}}';

    /**
     * @var string
     */
    public $tableItalianItem = '{{%catalog_italian_item}}';


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
            'specification_id' => $this->integer(11)->unsigned()->notNull(),
            'item_id' => $this->integer(11)->unsigned()->notNull(),
            'val' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_specification_id', $this->tableRel, 'specification_id');
        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_specification_id_item_id', $this->tableRel, ['specification_id', 'item_id'], true);

        $this->addForeignKey(
            'fk-catalog_specification_italian_item_value_ibfk_1',
            $this->tableRel,
            'specification_id',
            $this->tableSpecification,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_specification_italian_item_value_ibfk_2',
            $this->tableRel,
            'item_id',
            $this->tableItalianItem,
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
        $this->dropForeignKey('fk-catalog_specification_italian_item_value_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_specification_italian_item_value_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_specification_id_item_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);
        $this->dropIndex('idx_specification_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
