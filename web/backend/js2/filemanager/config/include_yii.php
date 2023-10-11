<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$baseDirExecPath = dirname(__DIR__, 5);
//
if (session_id() == '') session_start();
//
/* !!! */ echo  '<pre style="color:red;">'; print_r($_SESSION); echo '</pre>'; /* !!! */
if (!isset($_SESSION['TINYMCE_filemanager_ALLOW']) && $_SESSION['TINYMCE_filemanager_ALLOW'] !== true) {
    throw new Exception('Permission deny', 403);
}
