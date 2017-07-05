<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
?>
<div class="row">

    <!-- main start -->
    <!-- ================ -->
    <div class="main col-md-8 space-bottom">
        <p class="lead">
            Contacts text
        </p>

        <div class="alert alert-success hidden" id="MessageSent">
            We have received your message, we will contact you very soon.
        </div>
        <div class="alert alert-danger hidden" id="MessageNotSent">
            Oops! Something went wrong, please verify that you are not a robot or refresh the page and try again.
        </div>
        <div class="contact-form">
            <?= $this->render('parts/form', [
                'model' => $form
            ]) ?>
        </div>
    </div>
    <!-- main end -->

    <!-- sidebar start -->
    <!-- ================ -->
    <aside class="col-md-3 col-lg-offset-1">
        <div class="sidebar">
            <div class="side vertical-divider-left">
                <h3 class="title logo-font">The <span class="text-default">Project</span></h3>
            </div>
        </div>
    </aside>
    <!-- sidebar end -->
</div>
