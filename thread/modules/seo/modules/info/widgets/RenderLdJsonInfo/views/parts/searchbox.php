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
"url": "<?= $params['base-url'] ?>",
"potentialAction": {
"@type": "SearchAction",
"target": "<?= $params['web-site-search-action'] ?>",
"query-input": "required name=search_term_string"
}
}
