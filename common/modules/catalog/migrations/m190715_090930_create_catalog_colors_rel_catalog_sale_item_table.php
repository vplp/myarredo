<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_colors_rel_catalog_sale_item}}`.
 */
class m190715_090930_create_catalog_colors_rel_catalog_sale_item_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_colors_rel_catalog_sale_item}}';

    /**
     * @var string
     */
    public $tableProduct = '{{%catalog_sale_item}}';

    /**
     * @var string
     */
    public $tableColors = '{{%catalog_colors}}';

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
            'color_id' => $this->integer(11)->unsigned()->notNull(),
            'item_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_color_id', $this->tableRel, 'color_id');
        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_color_id_item_id', $this->tableRel, ['color_id', 'item_id'], true);

        $this->addForeignKey(
            'fk-catalog_colors_rel_catalog_sale_item_ibfk_1',
            $this->tableRel,
            'color_id',
            $this->tableColors,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_colors_rel_catalog_sale_item_ibfk_2',
            $this->tableRel,
            'item_id',
            $this->tableProduct,
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
        $this->dropForeignKey('fk-catalog_colors_rel_catalog_sale_item_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_colors_rel_catalog_sale_item_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_color_id_item_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);
        $this->dropIndex('idx_color_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
