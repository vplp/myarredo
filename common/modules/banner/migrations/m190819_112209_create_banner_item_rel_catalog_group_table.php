<?php

use yii\db\Migration;
//
use common\modules\banner\BannerModule;

/**
 * Handles the creation of table `{{%banner_item_rel_catalog_group}}`.
 */
class m190819_112209_create_banner_item_rel_catalog_group_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%banner_item_rel_catalog_group}}';

    /**
     * @var string
     */
    public $tableBanner = '{{%banner_item}}';

    /**
     * @var string
     */
    public $tableCatalogGroup = '{{%catalog_group}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = BannerModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableRel, [
            'item_id' => $this->integer(11)->unsigned()->notNull(),
            'category_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_category_id', $this->tableRel, 'category_id');
        $this->createIndex('idx_item_id_category_id', $this->tableRel, ['item_id', 'category_id'], true);

        $this->addForeignKey(
            'fk-banner_item_rel_catalog_group_ibfk_1',
            $this->tableRel,
            'item_id',
            $this->tableBanner,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-banner_item_rel_catalog_group_ibfk_2',
            $this->tableRel,
            'category_id',
            $this->tableCatalogGroup,
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
        $this->dropForeignKey('fk-banner_item_rel_catalog_group_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-banner_item_rel_catalog_group_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_item_id_category_id', $this->tableRel);
        $this->dropIndex('idx_category_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
