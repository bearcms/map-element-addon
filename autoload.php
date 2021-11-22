<?php

/*
 * Map element addon for Bear CMS
 * https://github.com/bearcms/map-element-addon
 * Copyright (c) Amplilabs Ltd.
 * Free to use under the MIT license.
 */

BearFramework\Addons::register('bearcms/map-element-addon', __DIR__, [
    'require' => [
        'bearcms/bearframework-addon',
        'bearframework/localization-addon',
        'ivopetkov/client-packages-bearframework-addon',
        'ivopetkov/responsively-lazy-bearframework-addon'
    ]
]);
