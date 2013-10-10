<?php
/**
  * Autorender file for The PHP/JS Local Docs Collection
  *
  * @author: Rafael Goulart <rafaelgou@gmail.com>
  */

require_once(__DIR__ . '/vendor/autoload.php');

use \Rgou\DocRenderer\Markdown as MdRenderer;
use \Rgou\DocRenderer\RestructuredText as RstRenderer;

// Loading config
$configFile = __DIR__ . '/autorender.yml';
if (file_exists($configFile)) {
    $yaml = new \Symfony\Component\Yaml\Parser();
    $config = $yaml->parse(file_get_contents($configFile));
} else {
    $config = array();
}

$mdRenderer = new MdRenderer($config);
$config     = $mdRenderer->getConfig();

// Checking text version    
$requested     = rawurldecode($config['requestUri']);
$requestParts  = explode( '-', $requested );
$extension     = array_pop(explode('.', $requested));

if (array_pop($requestParts) == $config['text_suffix']) {
    // replace the requested name with extension removed
    $requested = implode( '-', $requestParts );
    header( "Content-type: text/plain;charset=utf-8" );
    readfile( $_SERVER['DOCUMENT_ROOT'] . $requested );
    exit;
} elseif (in_array($extension, MdRenderer::$mdExtensions)) {
    echo $mdRenderer->render($_SERVER['DOCUMENT_ROOT'] . $requested);
} elseif (in_array($extension, MdRenderer::$rstExtensions)) {
    $rstRenderer = new RstRenderer($config);
    echo $rstRenderer->render($_SERVER['DOCUMENT_ROOT'] . $requested);
} else {
    echo '<h1>Not Found</h1>';
}
