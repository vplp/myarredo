<?php

use yii\db\Migration;
use thread\modules\news\News as ParentModule;

class m210218_154448_update_news_article_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%news_article}}';

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
        $this->addColumn($this->table, 'category_id', $this->integer(11)->unsigned()->notNull()->after('alias'));
        $this->createIndex('category_id', $this->table, 'category_id');

        $this->addColumn($this->table, 'factory_id', $this->integer(11)->unsigned()->notNull()->after('alias'));
        $this->createIndex('factory_id', $this->table, 'factory_id');

        $this->addColumn($this->table, 'city_id', $this->integer(11)->notNull()->defaultValue(0)->after('alias'));
        $this->createIndex('city_id', $this->table, 'city_id');
    }

    public function safeDown()
    {
        $this->dropIndex('category_id', $this->table);
        $this->dropColumn($this->table, 'category_id');

        $this->dropIndex('factory_id', $this->table);
        $this->dropColumn($this->table, 'factory_id');

        $this->dropIndex('city_id', $this->table);
        $this->dropColumn($this->table, 'city_id');
    }
}
