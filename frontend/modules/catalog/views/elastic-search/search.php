<?php

use yii\helpers\BaseStringHelper;

$this->title = 'Search';
?>
<div class="container-fluid">
    <h1>Search Result for <?php echo "<span class='label label-success'>" . $query . "</span>" ?></h1>
    <?php
    $result = $dataProvider->getModels();

    /* !!! */ echo  '<pre style="color:red;">'; print_r($result); echo '</pre>'; /* !!! */

    foreach ($result as $key) {

        echo "<div class='row'>";

        echo "<div class='panel panel-default'>";

        foreach ($key['_source'] as $key => $value) {

            if ($key == "title") {
                echo "<div class='panel-heading'>" . $value . "</div>";
            }

            if ($key == "description") {
                echo "<div class='panel-body'>" . BaseStringHelper::truncateWords($value, 50, '...', true) . "<br>";
            }
        }

        echo "</div>";
        echo "</div>";

    }
    ?>

</div>