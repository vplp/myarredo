<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m180126_135528_update_catalog_factory_table
 */
class m180126_135528_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_factory_lang}}';

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
        $this->addColumn($this->table, 'title', $this->string(255)->notNull()->after('alias'));

        $rows = (new \yii\db\Query())
            ->from($this->tableLang)
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

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'title');
    }
}
