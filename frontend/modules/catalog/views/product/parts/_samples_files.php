<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if(!empty($samples)) { ?>

<style>
    #sample-files-lists {
        border-top:1px solid #BDBCB3;
    }
</style>

<?php } ?>

<div class="factory-page">
    <div class="container-wrap">
        <div class="container large-container">
            <div class="row factory-det">
                <div class="descr">
                    <div class="fact-assort-wrap">
                        <div class="tab-content">
                            <div id="sample-files-lists" class="tab-pane fade in active">
                                <ul class="list">
                                    <?php
                                    foreach ($samplesFiles as $samplesFile) {
                                        if ($fileLink = $samplesFile->getFileLink()) {
                                            echo Html::beginTag('li') .
                                                Html::a(
                                                    ($samplesFile->image_link
                                                        ? Html::img($samplesFile->getImageLink())
                                                        : ''
                                                    ) .
                                                    Html::tag('span', $samplesFile->title . '<br>(' . date('d-m-Y', $samplesFile->updated_at) . ')', ['class' => 'for-catalog-list']),
                                                    Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink,
                                                    [
                                                        'target' => '_blank',
                                                        'class' => 'click-on-factory-file',
                                                        'data-id' => $samplesFile->id
                                                    ]
                                                ) .
                                                Html::endTag('li');
                                        }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
