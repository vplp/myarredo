<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog as ParentModule;

class m200203_122628_update_catalog_italian_item_lang_table extends Migration
{
    /**
    * @var string
    */
    public $table = '{{%catalog_italian_item_lang}}';

    /**
     * @throws \yii\base\InvalidConfigException
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
        $this->addColumn($this->table, 'title_for_list', $this->string(255)->notNull()->comment('Title')->after('title'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'title_for_list');
    }
}
