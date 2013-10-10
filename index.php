<?php
/**
  * Index file for The PHP/JS Local Docs Collection
  *
  * @author: Rafael Goulart <rafaelgou@gmail.com>
  */

require_once(__DIR__ . '/vendor/autoload.php');
$yaml = new \Symfony\Component\Yaml\Parser();

// Loading config
$configFile = __DIR__ . '/autorender.yml';
$config     = file_exists($configFile) ? $yaml->parse(file_get_contents($configFile)) : array();

// Loading sections
$sectionsFile = __DIR__ . '/sections.yml';
$sections     = file_exists($sectionsFile) ? $yaml->parse(file_get_contents($sectionsFile)) : array();

// Loading and Rendering Twig
$loader   = new \Twig_Loader_Filesystem($config['template_path']); 
$twig     = new \Twig_Environment($loader);
$template = $twig->loadTemplate('index.html.twig');

echo $template->render(array_merge($config, array('sections' => $sections)));

