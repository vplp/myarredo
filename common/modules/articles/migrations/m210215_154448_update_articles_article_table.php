<?php

use yii\db\Migration;
use common\modules\articles\Articles as ParentModule;

class m210215_154448_update_articles_article_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%articles_article}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn($this->table, 'city_id', $this->integer(11)->notNull()->defaultValue(0)->after('alias'));
        $this->createIndex('city_id', $this->table, 'city_id');
    }

    public function safeDown()
    {
        $this->dropIndex('city_id', $this->table);
        $this->dropColumn($this->table, 'city_id');
    }
}
