<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180711_114552_create_catalog_factory_promotion_rel_city extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_factory_promotion_rel_city}}';

    /**
     * @var string
     */
    public $tableCity = '{{%location_city}}';

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
            'city_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_promotion_id', $this->tableRel, 'promotion_id');
        $this->createIndex('idx_city_id', $this->tableRel, 'city_id');
        $this->createIndex('idx_promotion_id_city_id', $this->tableRel, ['promotion_id', 'city_id'], true);

        $this->addForeignKey(
            'fk-catalog_factory_promotion_rel_city_ibfk_1',
            $this->tableRel,
            'promotion_id',
            $this->tablePromotion,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_factory_promotion_rel_city_ibfk_2',
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
        $this->dropForeignKey('fk-catalog_factory_promotion_rel_city_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_factory_promotion_rel_city_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_promotion_id_city_id', $this->tableRel);
        $this->dropIndex('idx_city_id', $this->tableRel);
        $this->dropIndex('idx_promotion_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
