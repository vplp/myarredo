<?php
namespace thread\app\web\interfaces;

/**
 * interface InjectionLanguage
 *
 * @package thread\app\web\iface
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
interface InjectionLanguage
{
    /**
     * @param string $url
     * @return string
     */
    public static function processLangInUrl(string $url):string;

    /**
     * @param string $url
     * @return string
     */
    public static function addLangToUrl(string $url):string;
}