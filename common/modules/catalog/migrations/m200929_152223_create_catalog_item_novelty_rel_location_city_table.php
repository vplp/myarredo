<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

/**
 * Handles the creation of table `{{%catalog_item_novelty_rel_location_city}}`.
 */
class m200929_152223_create_catalog_item_novelty_rel_location_city_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_item_novelty_rel_location_city}}';

    /**
     * @var string
     */
    public $tableProduct = '{{%catalog_item}}';

    /**
     * @var string
     */
    public $tableLocationCity = '{{%location_city}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'catalog_item_id' => $this->integer(11)->unsigned()->notNull(),
            'location_city_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('catalog_item_id', $this->table, 'catalog_item_id');
        $this->createIndex('location_city_id', $this->table, 'location_city_id');
        $this->createIndex('catalog_item_id_location_city_id', $this->table, ['catalog_item_id', 'location_city_id'], true);

        $this->addForeignKey(
            'fk-catalog_item_novelty_rel_location_city_ibfk_1',
            $this->table,
            'location_city_id',
            $this->tableLocationCity,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_item_novelty_rel_location_city_ibfk_2',
            $this->table,
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
        $this->dropForeignKey('fk-catalog_item_novelty_rel_location_city_ibfk_1', $this->table);
        $this->dropForeignKey('fk-catalog_item_novelty_rel_location_city_ibfk_2', $this->table);

        $this->dropIndex('catalog_item_id_location_city_id', $this->table);

        $this->dropIndex('catalog_item_id', $this->table);
        $this->dropIndex('location_city_id', $this->table);

        $this->dropTable($this->table);
    }
}
