<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

return GeneralConfig::create()
    // Set the default week start day for date pickers (0 = Sunday, 1 = Monday, etc.)
    ->defaultWeekStartDay(1)
    // Prevent generated URLs from including "index.php"
    ->omitScriptNameInUrls()
    // Enable Dev Mode (see https://craftcms.com/guides/what-dev-mode-does)
    ->devMode(App::env('DEV_MODE') ?? false)
    // Preload Single entries as Twig variables
    ->preloadSingles()
    // Allow administrative changes
    ->allowAdminChanges(App::env('ALLOW_ADMIN_CHANGES') ?? false)
    // Disallow robots
    ->disallowRobots(App::env('DISALLOW_ROBOTS') ?? false)
    // Prevent user enumeration attacks
    ->preventUserEnumeration()
    // use emails as user names
    ->useEmailAsUsername(true)
    // never apply image transforms to gifs
    ->transformGifs(false)
    // never apply image transforms to svgs
    ->transformSvgs(false)
    // never upscale images
    ->upscaleImages(false)
    // limit entry revisions to a sensible amount
    ->maxRevisions(10)
    // the maximum upload file size allowed (50MB)
    ->maxUploadFileSize(52428800)
    // Disable template caching as the Blitz plugin will handle that
    ->enableTemplateCaching(false)
    // enable automatic queue running
    ->runQueueAutomatically(true)
    // Set the @webroot alias so the clear-caches command knows where to find CP resources
    ->aliases([
        '@webroot' => dirname(__DIR__) . '/web',
        '@web' => App::env('PRIMARY_SITE_URL'),
    ])
;
