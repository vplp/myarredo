<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m181105_115530_update_catalog_factory_promotion_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_promotion}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'start_date_promotion',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('payment_status')
        );
        $this->addColumn(
            $this->table,
            'end_date_promotion',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('start_date_promotion')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'end_date_promotion');
        $this->dropColumn($this->table, 'start_date_promotion');
    }
}
