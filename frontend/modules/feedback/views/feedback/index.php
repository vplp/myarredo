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

                <div class="separator-2 mt-20"></div>
                <ul class="list">
                    <li><i class="fa fa-home pr-10"></i>795 Folsom Ave, Suite 600<br><span class="pl-20">San Francisco, CA 94107</span>
                    </li>
                    <li><i class="fa fa-phone pr-10"></i><abbr title="Phone">P:</abbr> (123) 456-7890</li>
                    <li><i class="fa fa-mobile pr-10 pl-5"></i><abbr title="Phone">M:</abbr> (123) 456-7890</li>
                    <li><i class="fa fa-envelope pr-10"></i><a href="mailto:info@idea.com">info@theproject.com</a></li>
                </ul>
                <ul class="social-links circle small margin-clear clearfix animated-effect-1">
                    <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i
                                    class="fa fa-google-plus"></i></a></li>
                    <li class="flickr"><a target="_blank" href="http://www.flickr.com"><i class="fa fa-flickr"></i></a>
                    </li>
                    <li class="facebook"><a target="_blank" href="http://www.facebook.com"><i
                                    class="fa fa-facebook"></i></a></li>
                </ul>
                <div class="separator-2 mt-20 "></div>
            </div>
        </div>
    </aside>
    <!-- sidebar end -->
</div>
