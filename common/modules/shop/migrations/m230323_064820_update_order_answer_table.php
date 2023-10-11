<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m230323_064820_update_order_answer_table extends Migration
{

    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order_answer}}';
    public $files_table = '{{%files}}';


    /**
     * @inheritdoc
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
        $this->addColumn($this->table, 'file', $this->string(255)->defaultValue(null)->comment('Аttached file')->after('answer_time'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'file');
    }
}
