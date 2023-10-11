<?php

use yii\db\Migration;
//
use common\modules\banner\BannerModule;

class m191221_095457_update_banner_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%banner_item}}';

    /**
     *
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
        $this->addColumn(
            $this->table,
            'background_code',
            $this->string(32)->notNull()->after('side')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'background_code');
    }
}
