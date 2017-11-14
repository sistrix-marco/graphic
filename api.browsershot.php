<?php
$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : null;
$key = isset($_REQUEST['key']) ? $_REQUEST['key'] : null;
$png = null;
$filename = "/data/browsershots/".md5($url);

if (!$url || $key != 'XmkdiIUhid28OLld10lS') {

    /*
     * simple api-key
     */
    header((isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : "HTTP")." 404 Not Found", true, 404);
    die();

}

if (file_exists($filename) && filectime($filename) > strtotime('-28 days')) {

    /*
     * the image exists and is still up-to-date, just fetch the data
     */
    $png = file_get_contents($filename);

} else {

    /*
     * the image is not cached, so fetch the url
     * and store the image into the file
     */
    $URL2PNG_APIKEY = "ab7a71ba70d4b6a6eaa416e07590411516f983fc3014";

    /*
     * apply all arguments
     */
    $args = array();
    $args['width'] = 400;
    $args['format'] = 'PNG';
    $args['url'] = urlencode($url);
    foreach ($args as $key => $value) {
        $_parts[] = "$key=$value";
    }

    $png = file_get_contents("https://api.thumbnail.ws/api/$URL2PNG_APIKEY/thumbnail/get?".implode("&", $_parts));
    if ($png) {
        file_put_contents($filename, $png);
    }

}

if ($png) {

    /*
     * output the image
     */
    header('Content-Type: image/png');
    echo $png;

} else {

    /*
     * image is not in cache or could be fetched,
     * so set as internal error
     */
    header((isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : "HTTP")." 500 Internal Server Error", true, 500);

}