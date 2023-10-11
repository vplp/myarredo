<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180711_123932_create_catalog_factory_promotion_rel_catalog_item extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_factory_promotion_rel_catalog_item}}';

    /**
     * @var string
     */
    public $tableProduct = '{{%catalog_item}}';

    /**
     * @var string
     */
    public $tablePromotion = '{{%catalog_factory_promotion}}';

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
            'promotion_id' => $this->integer(11)->unsigned()->notNull(),
            'catalog_item_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_promotion_id', $this->tableRel, 'promotion_id');
        $this->createIndex('idx_catalog_item_id', $this->tableRel, 'catalog_item_id');
        $this->createIndex('idx_promotion_id_catalog_item_id', $this->tableRel, ['promotion_id', 'catalog_item_id'], true);

        $this->addForeignKey(
            'fk-catalog_factory_promotion_rel_catalog_item_ibfk_1',
            $this->tableRel,
            'promotion_id',
            $this->tablePromotion,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_factory_promotion_rel_catalog_item_ibfk_2',
            $this->tableRel,
            'catalog_item_id',
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
        $this->dropForeignKey('fk-catalog_factory_promotion_rel_catalog_item_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_factory_promotion_rel_catalog_item_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_promotion_id_catalog_item_id', $this->tableRel);
        $this->dropIndex('idx_catalog_item_id', $this->tableRel);
        $this->dropIndex('idx_promotion_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
