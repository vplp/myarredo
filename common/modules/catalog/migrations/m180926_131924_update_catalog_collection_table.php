<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180926_131924_update_catalog_collection_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_collection}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_collection_lang}}';

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
        $this->addColumn($this->table, 'user_id', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('factory_id'));
        $this->addColumn($this->table, 'title', $this->string(255)->defaultValue(null)->after('user_id'));

        $rows = (new \yii\db\Query())
            ->from($this->tableLang)
            ->where(['lang' => 'ru-RU'])
            ->all();

        foreach ($rows as $row) {
            // UPDATE
            $connection = Yii::$app->db;

            $connection->createCommand()
                ->update(
                    $this->table,
                    [
                        'title' => $row['title']
                    ],
                    'id = ' . $row['rid']
                )
                ->execute();
        }
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'title');
        $this->dropColumn($this->table, 'user_id');
    }
}
