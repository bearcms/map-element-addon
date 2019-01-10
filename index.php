<?php

/*
 * Map element addon for Bear CMS
 * https://github.com/bearcms/map-element-addon
 * Copyright (c) Amplilabs Ltd.
 * Free to use under the MIT license.
 */

use BearFramework\App;

$app = App::get();

$app->bearCMS->addons
        ->announce('bearcms/map-element-addon', function(\BearCMS\Addons\Addon $addon) use ($app) {
            $addon->initialize = function() use ($app) {
                $context = $app->context->get(__FILE__);

                $context->assets->addDir('assets');
                
                $app->localization
                ->addDictionary('en', function() use ($context) {
                    return include $context->dir . '/locales/en.php';
                })
                ->addDictionary('bg', function() use ($context) {
                    return include $context->dir . '/locales/bg.php';
                });

                \BearCMS\Internal\ElementsTypes::add('map', [
                    'componentSrc' => 'bearcms-map-element',
                    'componentFilename' => $context->dir . '/components/mapElement.php',
                    'fields' => [
                        [
                            'id' => 'query',
                            'type' => 'textbox'
                        ],
                        [
                            'id' => 'latitude',
                            'type' => 'textbox'
                        ],
                        [
                            'id' => 'longitude',
                            'type' => 'textbox'
                        ],
                        [
                            'id' => 'zoom',
                            'type' => 'textbox'
                        ],
                        [
                            'id' => 'type',
                            'type' => 'textbox'
                        ],
                        [
                            'id' => 'aspectRatio',
                            'type' => 'textbox'
                        ],
                        [
                            'id' => 'height',
                            'type' => 'textbox'
                        ]
                    ]
                ]);
                
                \BearCMS\Internal\Themes::$elementsOptions['map'] = function($context, $idPrefix, $parentSelector) {
                    $group = $context->addGroup(__('bearcms.themes.options.Map'));
                    $group->addOption($idPrefix . "MapCSS", "css", '', [
                        "cssTypes" => ["cssBorder", "cssRadius", "cssShadow"],
                        "cssOutput" => [
                            ["rule", $parentSelector . " .bearcms-map-element", "overflow:hidden;"],
                            ["selector", $parentSelector . " .bearcms-map-element"]
                        ]
                    ]);
                };
            };
        });
