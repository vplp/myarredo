<?php

use yii\db\Migration;
//
use common\modules\seo\Seo;

class m180124_112830_create_seo_direct_link_rel_location_city extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%seo_direct_link_rel_location_city}}';

    /**
     * @var string
     */
    public $tableSeoDirectLink = '{{%seo_direct_link}}';

    /**
     * @var string
     */
    public $tableLocationCity = '{{%location_city}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Seo::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'seo_direct_link_id' => $this->integer(11)->unsigned()->notNull(),
            'location_city_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('seo_direct_link_id', $this->table, 'seo_direct_link_id');
        $this->createIndex('location_city_id', $this->table, 'location_city_id');
        $this->createIndex('seo_direct_link_id_location_city_id', $this->table, ['seo_direct_link_id', 'location_city_id'], true);

        $this->addForeignKey(
            'fk-seo_direct_link_rel_location_city_ibfk_1',
            $this->table,
            'location_city_id',
            $this->tableLocationCity,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-seo_direct_link_rel_location_city_ibfk_2',
            $this->table,
            'seo_direct_link_id',
            $this->tableSeoDirectLink,
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
        $this->dropForeignKey('fk-seo_direct_link_rel_location_city_ibfk_1', $this->table);
        $this->dropForeignKey('fk-seo_direct_link_rel_location_city_ibfk_2', $this->table);

        $this->dropIndex('seo_direct_link_id_location_city_id', $this->table);

        $this->dropIndex('seo_direct_link_id', $this->table);
        $this->dropIndex('location_city_id', $this->table);

        $this->dropTable($this->table);
    }
}
