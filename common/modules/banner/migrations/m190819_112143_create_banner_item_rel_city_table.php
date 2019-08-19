<?php

use yii\db\Migration;
//
use common\modules\banner\BannerModule;

/**
 * Handles the creation of table `{{%banner_item_rel_city}}`.
 */
class m190819_112143_create_banner_item_rel_city_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%banner_item_rel_city}}';

    /**
     * @var string
     */
    public $tableBanner = '{{%banner_item}}';

    /**
     * @var string
     */
    public $tableCity = '{{%location_city}}';

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
            'city_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_item_id', $this->tableRel, 'item_id');
        $this->createIndex('idx_city_id', $this->tableRel, 'city_id');
        $this->createIndex('idx_item_id_city_id', $this->tableRel, ['item_id', 'city_id'], true);

        $this->addForeignKey(
            'fk-banner_item_rel_city_ibfk_1',
            $this->tableRel,
            'item_id',
            $this->tableBanner,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-banner_item_rel_city_ibfk_2',
            $this->tableRel,
            'city_id',
            $this->tableCity,
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
        $this->dropForeignKey('fk-banner_item_rel_city_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-banner_item_rel_city_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_item_id_city_id', $this->tableRel);
        $this->dropIndex('idx_city_id', $this->tableRel);
        $this->dropIndex('idx_item_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
