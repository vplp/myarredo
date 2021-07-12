<?php

namespace console\controllers;

use Yii;
use Imagick;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\seo\modules\directlink\models\{
    Directlink, DirectlinkLang
};
use frontend\modules\sys\models\Language;

/**
 * Class SeoDirectlinkController
 *
 * @package console\controllers
 */
class SeoDirectlinkController extends Controller
{
    /**
     * @param string $mark
     * @throws \yii\db\Exception
     */
    public function actionResetMark($mark = 'mark')
    {
        $this->stdout("Reset " . $mark . ": start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Directlink::tableName(), [$mark => '0'], $mark . "='1'")
            ->execute();

        $this->stdout("Reset " . $mark . ": finish. \n", Console::FG_GREEN);
    }

    /**
     * Translate
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        // Directlink
        $models = Directlink::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(1)
            ->orderBy(Directlink::tableName() . '.id DESC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Directlink */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

            foreach ($languages as $language) {
                Yii::$app->language = $language['local'];
                $currentLanguage = Yii::$app->language;

                /** @var $modelLang DirectlinkLang */
                $modelLang = DirectlinkLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                if ($modelLang != null) {
                    foreach ($languages as $language2) {
                        if ($language2['local'] != $currentLanguage) {
                            Yii::$app->language = $language2['local'];

                            /** @var $modelLang2 DirectlinkLang */
                            $modelLang2 = DirectlinkLang::find()
                                ->where([
                                    'rid' => $model->id,
                                    'lang' => Yii::$app->language,
                                ])
                                ->one();

                            if ($modelLang2 == null) {
                                $modelLang2 = new DirectlinkLang();
                                $modelLang2->rid = $model->id;
                                $modelLang2->lang = Yii::$app->language;


                                $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                $targetLanguageCode = substr($language2['local'], 0, 2);

                                $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                $title = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->title,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );
                                $description = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->description,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );
                                $h1 = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->h1,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );
                                $content = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->content,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                if ($title != '' || $description != '' || $h1 != '') {
                                    $transaction = $modelLang2::getDb()->beginTransaction();
                                    try {
                                        $title = str_replace(
                                            ['& ', ' / ', ' & ', '< p >', '< ', ' >', '&quot ', '&quot>'],
                                            ['&', '/', '&', '<p>', '<', '>', '&quot:', '&quot;>'],
                                            $title
                                        );
                                        $title = html_entity_decode($title);
                                        $title = str_replace(
                                            ['< p >', '< ', ' >'],
                                            ['<p>', '<', '>'],
                                            $title
                                        );

                                        $modelLang2->title = $title;
                                        $modelLang2->description = $description;
                                        $modelLang2->h1 = $h1;

                                        $content = str_replace(
                                            ['& ', ' / ', ' & ', '< p >', '< ', ' >', '&quot ', '&quot>'],
                                            ['&', '/', '&', '<p>', '<', '>', '&quot:', '&quot;>'],
                                            $content
                                        );
                                        $content = html_entity_decode($content);
                                        $content = str_replace(
                                            ['< p >', '< ', ' >'],
                                            ['<p>', '<', '>'],
                                            $content
                                        );

                                        $modelLang2->content = $content;

                                        $modelLang2->setScenario('backend');

                                        if ($saveLang[] = intval($modelLang2->save())) {
                                            $transaction->commit();
                                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
                                        } else {
                                            foreach ($modelLang2->errors as $attribute => $errors) {
                                                $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                                            }
                                        }
                                    } catch (Exception $e) {
                                        $transaction->rollBack();
                                        throw new Exception($e);
                                    }
                                } else {
                                    $saveLang[] = 0;
                                }
                            }
                        }
                    }
                }
            }

            $model->setScenario('mark');
            $model->mark = '1';

            if (!in_array(0, array_values($saveLang))) {
                $model->save();
                $this->stdout("translate ID = " . $model->id . " \n", Console::FG_GREEN);
            }

            $this->stdout("-------------------------------" . " \n", Console::FG_GREEN);
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }
}
