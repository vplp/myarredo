<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `catalog_italian_item_rel_catalog_group`.
 */
class m190123_094618_create_catalog_italian_item_rel_catalog_group_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_italian_item_rel_catalog_group}}';

    /**
     * @var string
     */
    public $tableGroup = '{{%catalog_group}}';

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
            'group_id' => $this->integer(11)->unsigned()->notNull(),
            'item_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('idx_group_id', $this->tableRel, 'group_id');
        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_group_id_item_id', $this->tableRel, ['group_id', 'item_id'], true);

        $this->addForeignKey(
            'fk-ccatalog_italian_item_rel_catalog_group_ibfk_1',
            $this->tableRel,
            'group_id',
            $this->tableGroup,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ccatalog_italian_item_rel_catalog_group_ibfk_2',
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
        $this->dropForeignKey('fk-ccatalog_italian_item_rel_catalog_group_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-ccatalog_italian_item_rel_catalog_group_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_group_id_item_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);
        $this->dropIndex('idx_group_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
