<?php

use yii\db\Migration;

/**
 * Class m160827_094012_create_table_rel_country_currency
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160827_094012_create_table_rel_country_currency extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tableRel = '{{%location_rel_country_currency}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableRel, [
            'country_id' => $this->integer(11)->unsigned()->notNull()->comment('country'),
            'currency_id' => $this->integer(11)->unsigned()->notNull()->comment('currency'),
        ]);

        $this->createIndex('country_id', $this->tableRel, 'country_id');
        $this->createIndex('currency_id', $this->tableRel, 'currency_id');
        $this->createIndex('country_id_2', $this->tableRel, ['country_id', 'currency_id'], true);

        $this->addForeignKey(
            'fv_location_rel_country_currency_ibfk_1',
            $this->tableRel,
            'country_id',
            'fv_location_country',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fv_location_rel_country_currency_ibfk_2',
            $this->tableRel,
            'currency_id',
            'fv_location_currency',
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
        $this->dropIndex('country_id_2', $this->tableRel);
        $this->dropIndex('country_id', $this->tableRel);
        $this->dropIndex('currency_id', $this->tableRel);
        $this->dropTable($this->tableRel);
    }
}
