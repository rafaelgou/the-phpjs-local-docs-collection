<?php
require_once(__DIR__ . '/vendor/autoload.php');

$sections = array(
    array(
        'label' => 'Symfony',
        'docs'  => array(
            array(
                'label' => 'Symfony 2.x',
                'links'  => array(
                    'symfony2/2.3/' => 'english 2.3',
                    'symfony2/docs-en/v2.2.0/' => 'english 2.2',
                    'symfony2/docs-pt-BR' => 'português 2.0',
                ),
            ),
            array(
                'label' => 'Doctrine 2 ORM',
                'links'  => array(
                    'doctrine2/' => 'Doctrine version 2.1', 
                    'dbal2/' => 'DBAL version 2.1', 
                ),
            ),
            array(
                'label' => 'Twig',
                'links'  => array(
                    'twig/' => 'version 1.13.0',
                ),
            ),
            array(
                'label' => 'Doctrine MongoDB ODM',
                'links'  => array(
                    'mongodb-odm/' => 'version 1.0',
                ),
            ),
            array(
                'label' => 'Symfony 1.4',
                'links'  => array(
                    'symfony1' => 'Index',
                ),
            ),
            array(
                'label' => 'Doctrine 1.2 ORM',
                'links'  => array(
                    'doctrine1/' => 'version 1.2',
                ),
            ),
            array(
                'label' => 'SwiftMailer',
                'links'  => array(
                    'swiftmailer/' => 'version 5.0.1',
                ),
            ),
        )
    ),
    array(
        'label' => 'Twitter Boostrap',
        'docs'  => array(
            array(
                'label' => 'Twitter Bootstrap',
                'links'  => array(
                    'twitter-bootstrap/3.0' => 'version 3.0',
                    'twitter-bootstrap/2.3' => 'version 2.3',
                ),
            ),
            array(
                'label' => 'Twitter Bootstrap Plugins',
                'links'  => array(
                    'twitter-bootstrap-plugins/' => 'all plugins',
                    'twitter-bootstrap-plugins/font-awesome/' => 'Font Awesome',
                    'twitter-bootstrap-plugins/fuelux/' => 'FuelUX',
                    'twitter-bootstrap-plugins/bootbox/' => 'Bootbox',
                    'twitter-bootstrap-plugins/datetimepicker/' => 'Datepicker',
                    'twitter-bootstrap-plugins/sortable/' => 'Sortable',
                ),
            ),
            array(
                'label' => 'Metro Mania Theme',
                'links'  => array(
                    'metro/' => 'the theme',
                ),
            ),
            array(
                'label' => 'Charisma Free HTML5 Bootstrap Admin Template',
                'links'  => array(
                    'charisma/' => 'the theme',
                ),
            ),
        )
    ),
    array(
        'label' => 'DataBases',
        'docs'  => array(
            array(
                'label' => 'MySQL Manual',
                'links'  => array(
                    'mysql/' => 'version 5.6',
                ),
            ),
            array(
                'label' => 'The MongoDB Manual',
                'links'  => array(
                    'mongodb/' => 'version 2.4',
                ),
            ),
            array(
                'label' => 'PostgreSQL',
                'links'  => array(
                    'postgresql/' => 'version 9.1.9',
                ),
            ),
            array(
                'label' => 'SphinxSearch',
                'links'  => array(
                    'sphinxsearch/' => 'version 2.1.1 beta',
                ),
            ),
        )
    ),

    array(
        'label' => 'PHP',
        'docs'  => array(
            array(
                'label' => 'PHP',
                'links'  => array(
                    'php/en' => 'english 5.3',
                    'php/br' => 'português 5.3',
                ),
            ),
            array(
                'label' => 'PHPUnit',
                'links'  => array(
                    'phpunit/en' => 'english',
                    'phpunit/pt-BR' => 'português',
                ),
            ),
            array(
                'label' => 'Yaml',
                'links'  => array(
                    'yaml/' => 'version 1.2',
                ),
            ),
            array(
                'label' => 'Composer',
                'links'  => array(
                    'composer/' => 'version ?',
                ),
            ),
        )
    ),
    array(
        'label' => 'Javascript',
        'docs'  => array(
            array(
                'label' => 'jQuery API',
                'links'  => array(
                    'jqapi/' => 'version 1.9.x',
                ),
            ),
            array(
                'label' => 'NodeJS',
                'links'  => array(
                    'nodejs/' => 'version 0.10.18',
                ),
            ),
            array(
                'label' => 'NPM Node Package Manager',
                'links'  => array(
                    'npm/' => 'version 1.3.11',
                ),
            ),
            array(
                'label' => 'RequireJS',
                'links'  => array(
                    'requirejs/' => 'version 2.1.8',
                ),
            ),
            array(
                'label' => 'AngularJS',
                'links'  => array(
                    'angularjs/' => 'version 0.10.6',
                ),
            ),
            array(
                'label' => 'BackboneJS',
                'links'  => array(
                    'backbonejs/' => 'version 1.0',
                ),
            ),
            array(
                'label' => 'UnderscoreJS',
                'links'  => array(
                    'underscorejs/' => 'version 1.5.2',
                ),
            ),
            array(
                'label' => 'jQuery UI',
                'links'  => array(
                    'jqueryui/' => 'Index',
                    'jqueryui/development-bundle/docs/' => 'API Docs',
                    'jqueryui/development-bundle/demos/' => 'Demos',
                ),
            ),
            array(
                'label' => 'jQuery Plugins',
                'links'  => array(
                    'jquery-plugins/' => 'various',
                ),
            ),
            array(
                'label' => 'NodeJS Modules',
                'links'  => array(
                    'nodejs-modules/swig' => 'Swig Template Engine v1.0.0-rc2',
                    'jade/' => 'Jade Template Engine v0.35.0',
                ),
            ),
        ),
    ),
    array(
        'label' => 'GIT',
        'docs'  => array(
            array(
                'label' => 'GIT Reference',
                'links'  => array(
                    'gitref' => 'version ?',
                ),
            ),
            array(
                'label' => 'ProGIT Book',
                'links'  => array(
                    'progit/' => 'Index (en, pt-BR)',
                ),
            ),
            array(
                'label' => 'GIT Magic',
                'links'  => array(
                    'gitmagic/en' => 'english',
                    'gitmagic/pt-br' => 'português',
                ),
            ),
        )
    ),
    array(
        'label' => 'Doc Markups',
        'docs'  => array(
            array(
                'label' => 'reStructuredText',
                'links'  => array(
                    'restructuredtext/cheatsheet/rst-cheatsheet.rst' => 'CheatSheet',
                    'restructuredtext/sphinx/rest.html' => 'Sphinx reStructuredText restructuredtext',
                    'Syntax/cheatsheet1' => 'Another CheatSheet',
                    'restructuredtext/manual' => 'Manual',
                    'restructuredtext/sphinx' => 'Sphinx Site',
                    'restructuredtext/sphinx/contents.html' => 'Sphinx Manual',
                    'restructuredtext/sphinx/tutorial.html' => 'Sphinx Tutorial',
                ),
            ),
            array(
                'label' => 'Markdown Guide',
                'links'  => array(
                    'markdown/guide/' => 'version ?',
                ),
            ),
            array(
                'label' => 'Pandoc',
                'links'  => array(
                    'pandoc/' => 'version ?',
                ),
            ),
        )
    ),
    array(
        'label' => 'Outros',
        'docs'  => array(
            array(
                'label' => 'Apache2',
                'links'  => array(
                    'apache2/en' => 'english 2.2',
                    'apache2/pt-br' => 'português 2.2',
                ),
            ),
            array(
                'label' => 'Guia Expressões Regulares',
                'links'  => array(
                    'guia-er/' => 'Index',
                ),
            ),
            array(
                'label' => 'CodeIgniter User Guide ',
                'links'  => array(
                    'codeigniter' => 'version 2.1.2',
                ),
            ),
        ),
    ),

);

use Symfony\Component\Yaml\Dumper;
$dumper = new Dumper();
$yaml = $dumper->dump($sections, 5);
file_put_contents(__DIR__ . '/sections.yml', $yaml);



