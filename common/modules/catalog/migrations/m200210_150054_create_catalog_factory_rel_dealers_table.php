<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_factory_rel_dealers}}`.
 */
class m200210_150054_create_catalog_factory_rel_dealers_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_factory_rel_dealers}}';

    /**
     * @var string
     */
    public $tableFactory = '{{%catalog_factory}}';

    /**
     * @var string
     */
    public $tableDealers = '{{%user}}';

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
            'factory_id' => $this->integer(11)->unsigned()->notNull(),
            'dealer_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('factory_id', $this->tableRel, 'factory_id');
        $this->createIndex('dealer_id', $this->tableRel, 'dealer_id');
        $this->createIndex('factory_id_dealer_id', $this->tableRel, ['factory_id', 'dealer_id'], true);

        $this->addForeignKey(
            'fk-catalog_factory_rel_dealers_ibfk_1',
            $this->tableRel,
            'factory_id',
            $this->tableFactory,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_factory_rel_dealers_ibfk_2',
            $this->tableRel,
            'dealer_id',
            $this->tableDealers,
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
        $this->dropForeignKey('fk-catalog_factory_rel_dealers_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-catalog_factory_rel_dealers_ibfk_1', $this->tableRel);

        $this->dropIndex('factory_id_dealer_id', $this->tableRel);
        $this->dropIndex('dealer_id', $this->tableRel);
        $this->dropIndex('factory_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
