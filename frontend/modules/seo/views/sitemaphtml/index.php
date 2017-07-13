<?php
use yii\helpers\Html;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
?>
<div class="row">

    <div class="main col-md-12">

        <h1 class="page-title">Page Sitemap</h1>

        <div class="separator-2"></div>

        <div class="row">
            <div class="col-md-4">
                <h3>Catalog groups</h3>
                <?php if ($catalog_groups):
                    echo Html::beginTag('ul', [
                        'class' => 'list'
                    ]);
                    foreach ($catalog_groups as $group):
                        echo Html::tag('li', Html::a('<i class="icon-right-open"></i>' . $group['lang']['title'], $group->getUrl()));
                    endforeach;;
                    echo Html::endTag('ul');
                endif;
                ?>
            </div>
            <div class="col-md-4">
                <h3>Trademark</h3>
                <?php if ($pages):
                    echo Html::beginTag('ul', [
                        'class' => 'list'
                    ]);
                    foreach ($trademarks as $trademark):
                        echo Html::tag('li', Html::a('<i class="icon-right-open"></i>' . $trademark['lang']['title'], $trademark->getUrl()));
                    endforeach;;
                    echo Html::endTag('ul');
                endif;
                ?>
            </div>
            <div class="col-md-4">
                <h3>Pages</h3>
                <?php if ($pages):
                    echo Html::beginTag('ul', [
                        'class' => 'list'
                    ]);
                    foreach ($pages as $page):
                        echo Html::tag('li', Html::a('<i class="icon-right-open"></i>' . $page['lang']['title'], $page->getUrl()));
                    endforeach;;
                    echo Html::endTag('ul');
                endif;
                ?>
            </div>
        </div>

    </div>

</div>
