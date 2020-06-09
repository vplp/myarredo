<?php

use frontend\modules\catalog\models\FactoryCatalogsFiles;

/**
 * @var $model FactoryCatalogsFiles
 */

?>

    <div id="viewerContainer">
        <div id="viewer" class="pdfViewer"></div>
    </div>

<?php

$this->registerJsFile(
    'https://mozilla.github.io/pdf.js/build/pdf.js',
    ['position' => yii\web\View::POS_END,]
);
$this->registerJsFile(
    'https://mozilla.github.io/pdf.js/web/pdf_viewer.js',
    ['position' => yii\web\View::POS_END,]
);

$script = <<<JS
var url = '/uploads/myarredofamily-for-partners.pdf';


JS;

$this->registerJs($script);
