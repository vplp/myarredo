<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m200513_085034_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

    /**
     * table name
     * @var string
     */
    public $tableCity = '{{%location_city}}';

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
        $this->addColumn($this->table, 'admin_comment', $this->string(512)->notNull()->defaultValue('')->comment('Comment')->after('comment'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'admin_comment');
    }
}
