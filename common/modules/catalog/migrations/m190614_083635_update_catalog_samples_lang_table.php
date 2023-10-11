<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190614_083635_update_catalog_samples_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_samples}}';

    /**
     * table lang name
     * @var string
     */
    public $tableLang = '{{%catalog_samples_lang}}';

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
        $rows = (new \yii\db\Query())
            ->from($this->tableLang)
            ->where(['lang' => 'ru-RU'])
            ->all();

        foreach ($rows as $row) {
            $existingModel = (new \yii\db\Query())
                ->from($this->tableLang)
                ->where(['rid' => $row['rid'], 'lang' => 'it-IT'])
                ->one();

            $connection = Yii::$app->db;

            if ($existingModel == null) {
                $connection->createCommand()
                    ->insert(
                        $this->tableLang,
                        ['rid' => $row['rid'], 'lang' => 'it-IT', 'title' => $row['title']]
                    )
                    ->execute();
            } else {
                $connection->createCommand()
                    ->update(
                        $this->tableLang,
                        ['title' => $row['title']],
                        ['rid' => $row['rid'], 'lang' => 'it-IT']
                    )
                    ->execute();
            }
        }

        foreach ($rows as $row) {
            $existingModel = (new \yii\db\Query())
                ->from($this->tableLang)
                ->where(['rid' => $row['rid'], 'lang' => 'en-EN'])
                ->one();

            $connection = Yii::$app->db;

            if ($existingModel == null) {
                $connection->createCommand()
                    ->insert(
                        $this->tableLang,
                        ['rid' => $row['rid'], 'lang' => 'en-EN', 'title' => $row['title']]
                    )
                    ->execute();
            } else {
                $connection->createCommand()
                    ->update(
                        $this->tableLang,
                        ['title' => $row['title']],
                        ['rid' => $row['rid'], 'lang' => 'en-EN']
                    )
                    ->execute();
            }
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        return true;
    }
}
