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
    ->register('bearcms/map-element-addon', function (\BearCMS\Addons\Addon $addon) use ($app): void {
        $addon->initialize = function () use ($app): void {
            $context = $app->contexts->get(__DIR__);

            $context->assets->addDir('assets');

            $app->localization
                ->addDictionary('en', function () use ($context) {
                    return include $context->dir . '/locales/en.php';
                })
                ->addDictionary('bg', function () use ($context) {
                    return include $context->dir . '/locales/bg.php';
                });

            $type = new \BearCMS\Internal\ElementType('map', 'bearcms-map-element', $context->dir . '/components/mapElement.php');
            $type->properties = [
                [
                    'id' => 'query',
                    'type' => 'string'
                ],
                [
                    'id' => 'latitude',
                    'type' => 'string'
                ],
                [
                    'id' => 'longitude',
                    'type' => 'string'
                ],
                [
                    'id' => 'zoom',
                    'type' => 'string'
                ],
                [
                    'id' => 'type',
                    'type' => 'string'
                ],
                [
                    'id' => 'aspectRatio',
                    'type' => 'string'
                ],
                [
                    'id' => 'height',
                    'type' => 'string'
                ]
            ];
            \BearCMS\Internal\ElementsTypes::add($type);

            \BearCMS\Internal\Themes::$elementsOptions['map'] = function ($context, $idPrefix, $parentSelector): void {
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
