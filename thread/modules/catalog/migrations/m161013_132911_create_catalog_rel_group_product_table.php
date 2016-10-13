<?php

use yii\db\Migration;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class m161013_132911_create_catalog_rel_group_product_table
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class m161013_132911_create_catalog_rel_group_product_table extends Migration
{
    /**
     * Catalog group table name
     * @var string
     */
    public $tableRel = '{{%catalog_rel_group_product}}';

    /**
     * Catalog group table name
     * @var string
     */
    public $tableGroup = '{{%catalog_group}}';

    /**
     * Catalog product table name
     * @var string
     */
    public $tableProduct = '{{%catalog_product}}';

    /**
     *
     */
    public function init()
    {
        $this->db = CatalogModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableRel, [
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('group'),
            'product_id' => $this->integer(11)->unsigned()->notNull()->comment('product'),
            'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
        ]);

        $this->createIndex('group_id', $this->tableRel, 'group_id');
        $this->createIndex('product_id', $this->tableRel, 'product_id');
        $this->createIndex('group_id_product_id', $this->tableRel, ['group_id', 'product_id'], true);

        $this->addForeignKey(
            'fk-catalog_rel_group_product_ibfk_1',
            $this->tableRel,
            'group_id',
            $this->tableGroup,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_rel_group_product_ibfk_2',
            $this->tableRel,
            'product_id',
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
        $this->dropIndex('group_id_product_id', $this->tableRel);
        $this->dropIndex('group_id', $this->tableRel);
        $this->dropIndex('product_id', $this->tableRel);
        $this->dropTable($this->tableRel);
    }
}