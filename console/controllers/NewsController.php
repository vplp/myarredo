<?php

namespace console\controllers;

use Yii;
use Imagick;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\news\models\{
    Article, ArticleLang
};
use frontend\modules\sys\models\Language;

/**
 * Class NewsController
 *
 * @package console\controllers
 */
class NewsController extends Controller
{
    /**
     * @param string $mark
     * @throws \yii\db\Exception
     */
    public function actionResetMark($mark = 'mark')
    {
        $this->stdout("Reset " . $mark . ": start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Article::tableName(), [$mark => '0'], $mark . "='1'")
            ->execute();

        $this->stdout("Reset " . $mark . ": finish. \n", Console::FG_GREEN);
    }

    /**
     * Translate
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        // Article
        $models = Article::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(5)
            ->orderBy(Article::tableName() . '.id DESC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Article */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

            foreach ($languages as $language) {
                Yii::$app->language = $language['local'];
                $currentLanguage = Yii::$app->language;

                /** @var $modelLang ArticleLang */
                $modelLang = ArticleLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                if ($modelLang != null) {
                    foreach ($languages as $language2) {
                        if ($language2['local'] != $currentLanguage) {
                            Yii::$app->language = $language2['local'];

                            /** @var $modelLang2 ArticleLang */
                            $modelLang2 = ArticleLang::find()
                                ->where([
                                    'rid' => $model->id,
                                    'lang' => Yii::$app->language,
                                ])
                                ->one();

                            if ($modelLang2 == null) {
                                $modelLang2 = new ArticleLang();
                                $modelLang2->rid = $model->id;
                                $modelLang2->lang = Yii::$app->language;

                                $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                $targetLanguageCode = substr($language2['local'], 0, 2);

                                $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                $title = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->title, //str_replace("&nbsp;", ' ', strip_tags($modelLang->title)),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );
                                $description = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->description, //str_replace("&nbsp;", ' ', strip_tags($modelLang->description)),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );
                                $content = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->content, //str_replace("&nbsp;", ' ', strip_tags($modelLang->content)),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                $title = html_entity_decode(htmlentities($title));
                                $description = html_entity_decode(htmlentities($description));
                                $content = html_entity_decode(htmlentities($content));

                                /* !!! */ echo  '<pre style="color:red;">'; print_r($content); echo '</pre>'; /* !!! */

                                $saveLang[] = 0;

//                                if ($title != '' || $description != '' || $content != '') {
//                                    $transaction = $modelLang2::getDb()->beginTransaction();
//                                    try {
//                                        $modelLang2->title = $title;
//                                        $modelLang2->description = $description;
//                                        $modelLang2->content = $content;
//
//                                        $modelLang2->setScenario('backend');
//
//                                        if ($saveLang[] = intval($modelLang2->save())) {
//                                            $transaction->commit();
//                                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
//                                        } else {
//                                            foreach ($modelLang2->errors as $attribute => $errors) {
//                                                $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
//                                            }
//                                        }
//                                    } catch (Exception $e) {
//                                        $transaction->rollBack();
//                                        throw new Exception($e);
//                                    }
//                                } else {
//                                    $saveLang[] = 0;
//                                }
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
