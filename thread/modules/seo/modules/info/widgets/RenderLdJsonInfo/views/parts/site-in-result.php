<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
?>
{
"@context": "http://schema.org",
"@type": "WebSite",
"name": "<?= $params['web-site-name'] ?>",
<?php if (isset($params['web-site-alternatename'])): ?>"alternateName": "<?= $params['web-site-alternatename'] ?>",<?php endif; ?>
"url": "<?= $params['base-url'] ?>"
}
