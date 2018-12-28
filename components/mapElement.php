<?php

use BearFramework\App;

$app = App::get();
$context = $app->context->get(__FILE__);

$googleMapParameters = [];
if (strlen($component->query) > 0) {
    $googleMapParameters['query'] = $component->query;
}
if (strlen($component->latitude) > 0) {
    $googleMapParameters['latitude'] = $component->latitude;
}
if (strlen($component->longitude) > 0) {
    $googleMapParameters['longitude'] = $component->longitude;
}
if (strlen($component->zoom) > 0) {
    $googleMapParameters['zoom'] = $component->zoom;
}
if (strlen($component->type) > 0) {
    $googleMapParameters['type'] = $component->type;
}
$aspectRatio = $component->aspectRatio;
$height = $component->height;

if (strlen($aspectRatio) > 0) {
    $aspectRatioParts = explode(':', $aspectRatio);
    $paddingBottom = '75%';
    if (sizeof($aspectRatioParts) === 2 && is_numeric($aspectRatioParts[0]) && is_numeric($aspectRatioParts[1])) {
        $paddingBottom = ((float) $aspectRatioParts[1] / (float) $aspectRatioParts[0] * 100) . '%';
    }
    $containerStyle = 'padding-bottom:' . $paddingBottom . ';';
} else {
    if (strlen($height) === 0) {
        $height = '420px';
    }
    $containerStyle = 'height:' . $height . ';';
}

$getGoogleMapUrl = function(array $parameters) {
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
//$googleMapParameters['query'] = 'супермаркет';
$content = '<iframe src="' . $getGoogleMapUrl($googleMapParameters) . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>';
$content = '<div class="responsively-lazy" style="' . $containerStyle . 'font-size:0;line-height:0;" data-lazycontent="' . htmlentities($content) . '"></div>';
?><html>
    <head>
        <style id="responsively-lazy-style">.responsively-lazy:not(img){position:relative;height:0;}.responsively-lazy:not(img)>img{position:absolute;top:0;left:0;width:100%;height:100%}img.responsively-lazy{width:100%;}</style>
        <script id="responsively-lazy-script" src="<?= $context->assets->getUrl('assets/responsivelyLazy.min.js', ['cacheMaxAge' => 999999999, 'version' => 2]) ?>" async/>
    </head>
    <body><?= $content ?></body>
</html>