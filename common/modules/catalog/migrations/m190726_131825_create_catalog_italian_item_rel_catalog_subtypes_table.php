<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_italian_item_rel_catalog_subtypes}}`.
 */
class m190726_131825_create_catalog_italian_item_rel_catalog_subtypes_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_italian_item_rel_catalog_subtypes}}';

    /**
     * @var string
     */
    public $tableType = '{{%catalog_subtypes}}';

    /**
     * @var string
     */
    public $tableItem = '{{%catalog_italian_item}}';


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
            'subtype_id' => $this->integer(11)->unsigned()->notNull(),
            'item_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('idx_subtype_id', $this->tableRel, 'subtype_id');
        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_subtype_id_item_id', $this->tableRel, ['subtype_id', 'item_id'], true);

        $this->addForeignKey(
            'fk-catalog_italian_item_rel_catalog_subtypes_ibfk_1',
            $this->tableRel,
            'subtype_id',
            $this->tableType,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_italian_item_rel_catalog_subtypes_ibfk_2',
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
        $this->dropForeignKey('fk-catalog_italian_item_rel_catalog_subtypes_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_italian_item_rel_catalog_subtypes_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_subtype_id_item_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);
        $this->dropIndex('idx_subtype_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
