<?php
/*
 * Map element addon for Bear CMS
 * https://github.com/bearcms/map-element-addon
 * Copyright (c) Amplilabs Ltd.
 * Free to use under the MIT license.
 */

$googleMapParameters = [];
if (strlen((string)$component->query) > 0) {
    $googleMapParameters['query'] = $component->query;
}
if (strlen((string)$component->latitude) > 0) {
    $googleMapParameters['latitude'] = $component->latitude;
}
if (strlen((string)$component->longitude) > 0) {
    $googleMapParameters['longitude'] = $component->longitude;
}
if (strlen((string)$component->zoom) > 0) {
    $googleMapParameters['zoom'] = $component->zoom;
}
if (strlen((string)$component->type) > 0) {
    $googleMapParameters['type'] = $component->type;
}
$aspectRatio = (string)$component->aspectRatio;
$height = (string)$component->height;

if (strlen($aspectRatio) > 0) {
    $aspectRatioParts = explode(':', $aspectRatio);
    $paddingBottom = '75%';
    if (sizeof($aspectRatioParts) === 2 && is_numeric($aspectRatioParts[0]) && is_numeric($aspectRatioParts[1])) {
        $widthRatio = (float) $aspectRatioParts[0];
        $heightRatio = (float) $aspectRatioParts[1];
        if ($widthRatio > 0 && $heightRatio > 0) {
            if ($heightRatio / $widthRatio > 10) { // prevent super tall element
                $heightRatio = $widthRatio * 10;
            }
            $paddingBottomValue = ($heightRatio / $widthRatio * 100);
            if ($paddingBottomValue >= 0) {
                $paddingBottom = $paddingBottomValue . '%';
            }
        }
    }
    $containerStyle = 'position:relative;height:0;padding-bottom:' . $paddingBottom . ';';
} else {
    if (strlen($height) === 0) {
        $height = '420px';
    }
    $containerStyle = 'position:relative;height:' . $height . ';';
}

$getGoogleMapURL = function (array $parameters) {
    $url = 'https://maps.google.com/maps?';
    if (isset($parameters['query'])) {
        if (strlen($parameters['query']) > 0) {
            $url .= 'q=' . urlencode($parameters['query']);
        }
    } elseif (isset($parameters['latitude'], $parameters['longitude']) && strlen($parameters['latitude']) > 0 && strlen($parameters['longitude']) > 0) {
        $url .= 'q=' . urlencode($parameters['latitude'] . ',' . $parameters['longitude']);
    }
    if (isset($parameters['type']) && $parameters['type'] === 'satellite') {
        $url .= '&t=k';
    }
    if (isset($parameters['zoom']) && strlen($parameters['zoom']) > 0) {
        $url .= '&z=' . (float) $parameters['zoom'];
    }
    $url .= '&ie=UTF8&output=embed';
    return $url;
};
$content = '<iframe src="' . $getGoogleMapURL($googleMapParameters) . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>';
echo '<html><head>';
echo '<link rel="client-packages-embed" name="responsivelyLazy">';
echo '</head><body>';
echo '<div class="bearcms-map-element" style="' . $containerStyle . 'font-size:0;line-height:0;" data-responsively-lazy-type="html" data-responsively-lazy="' . htmlentities($content) . '"></div>';
echo '</body></html>';
