#The PHP/Javascript Local Docs Collection

A HUGE doc collection for PHP and Javascript web developers.

Compiled by [Rafael Goulart](http://github.com/rafaelgou).

You can see a demo in [rgou.net The PHP/JSC LDC Install](http://the-phpjs-ldc.rgou.net).

## Install

Be sure to have PHP-CLI instaled.

Use a local Apache install directory for cloning.

Considering a default Apache installation:

    cd /var/www
    git clone https://github.com/rafaelgou/the-phpjs-local-docs-collection.git

And have a coffee (it's about 650Mb to download from GitHub).

Now you need [Composer](http://getcomposer.org).

Start by downloading Composer onto your computer. If you have curl installed, it’s as easy as:

    cd the-phpjs-local-docs-collection
    curl -s https://getcomposer.org/installer | php

With composer installed, then you get the dependencies:

    ./composer.phar install

Copy `autorender.yml.dist` to `autorender.yml`:

    cp autorender.yml.dist autorender.yml

Be sure to open this file and check the default paths. If you've followed the instructions above,
you've used `/var/www` as parent and clone without changing the target directory, 
then the default values are enough. 

If your local web server runs on http://localhost, then you are able now to navigate on
http://localhost/the-phpjs-local-docs-collection .

That's all!

## What is for?

I a kind of paranoic about being offline without any references.

So I do this research and put almost everything I need offline.

## All Local?

Yes, but eventually some docs still gets some assets remotely.
As soon as I discover, I will clean up.

## Where are the docs sources?

If it's possible, direct download in HTML

Then I'd made a search on  http://readthedocs.org - and downloaded from there.

If it's possible, I'd compiled from the sources.

If the docs are on Markdow I'd used https://github.com/rafaelgou/doc-renderer to render on-the-fly from sources.

Some was taken from `apt-get install bla-docs`

If still not avaliable, brute-force `wget` and manual cleaning was the last try.

## What is still missing?

Good Javascript, DOM and CSS references are not available for download (if you find anywhere, tell me!).

But you can run a local instace of [DocHub](https://github.com/rgarcia/dochub), it's pretty awesome!

## What is in the list?

Here we go:

* PHP
    * PHP
        * [english 5.3](http://www.php.net/manual/en/index.php)
        * [português 5.3](http://www.php.net/manual/pt_BR/index.php)
    * PHPUnit
        * [english](http://phpunit.de/manual/current/en/index.html)
        * [português](http://phpunit.de/manual/current/pt_br/index.html)
    * Yaml
        * [version 1.2](http://yaml.org/spec/1.2/spec.html)
    * Composer
        * [version ?](http://getcomposer.org/)
* JS
    * jQuery API
        * [version 1.9.x](http://api.jquery.com/)
    * jQuery UI
        * [Index](http://jqueryui.com/)
        * [API Docs](http://api.jqueryui.com/)
        * [Demos](http://jqueryui.com/demos/)
    * jQuery Plugins
        * [Datatables 1.9.4](http://datatables.net/'')
        * [Chosen 1.0.0](http://harvesthq.github.io/chosen/)
        * [jQuery File Upload](http://blueimp.github.io/jQuery-File-Upload/)
    * RequireJS
        * [version 2.1.8](requirejs.org)
    * AngularJS
        * [version 0.10.6](code.angularjs.org/)
    * BackboneJS
        * [version 1.0](http://backbonejs.org/)
    * UnderscoreJS
        * [version 1.5.2](http://underscorejs.org/)
    * NodeJS
        * [version 0.10.18](nodejs.org)
    * NPM Node Package Manager
        * [version 1.3.11](npmjs.org)
    * NodeJS Modules
        * [Swig Template Engine v1.0.0-rc2](http://paularmstrong.github.io/swig/)
        * [Jade Template Engine v0.35.0](jade-lang.com)
        * [Consolidate](https://npmjs.org/package/consolidate)
* Symfony
    * Symfony 2.x
        * [english 2.3](http://symfony.com/doc/current/index.html)
    * Doctrine 2 ORM
        * [Doctrine version 2.4](http://www.doctrine-project.org/docs/orm/2.4/en/index.html)
        * [Doctrine ODM version 2.0](http://www.doctrine-project.org/docs/orm/2.4/en/index.html)
        * [DBAL version 2.4](http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/index.html)
    * Twig
        * [version 1.13.0](twig.sensiolabs.org)
    * Symfony 1.4
        * [Index](http://symfony.com/legacy/doc)
    * Doctrine 1.2 ORM
        * [version 1.2](http://doctrine1.readthedocs.org/en/latest/)
    * SwiftMailer
        * [version 5.0.1](swiftmailer.org)
* Bootstrap
    * Twitter Bootstrap
        * [version 3.0](getbootstrap.com)
        * [version 2.3](http://getbootstrap.com/2.3.2/)
        * [Bootswatch Themes](bootswatch.com)
    * Twitter Bootstrap Plugins
        * [Font Awesome](fontawesome.io)
        * [FuelUX](http://exacttarget.github.io/fuelux/)
        * [Bootbox 2.3]()
        * [Bootbox 3.0](http://bootboxjs.com/)
        * [Datepicker](http://bootboxjs.com/)
        * [Sortable](http://johnny.github.io/jquery-sortable/)
        * [Typeahead Advanced](http://twitter.github.io/typeahead.js/)
* DB
    * MySQL Manual
        * [version 5.6](http://dev.mysql.com/doc/)
    * The MongoDB Manual
        * [version 2.4](http://docs.mongodb.org/manual/)
    * PostgreSQL
        * [version 9.1.9](http://www.postgresql.org/docs/9.2/static/)
    * SphinxSearch
        * [version 2.1.1 beta]()
* GIT
    * GIT Reference
        * [version ?](http://gitref.org/)
    * GIT Magic
        * [english](http://www-cs-students.stanford.edu/~blynn/gitmagic/)
        * [português](http://www-cs-students.stanford.edu/~blynn/gitmagic/intl/pt_br/)
* Doc Markups
    * reStructuredText
        * [Manual]()
        * [Sphinx reStructuredText](http://sphinx-doc.org/rest.html)
        * [CheatSheet 1]()
        * [CheatSheet 2]()
    * Sphinx-Pocoo
        * [Sphinx Site](http://sphinx-doc.org/)
        * [Sphinx Manual](http://sphinx-doc.org/contents.html)
        * [Sphinx Tutorial](http://sphinx-doc.org/tutorial.html)
    * Markdown Guide
        * [version ?](https://readthedocs.org/projects/markdown-guide/)
    * Pandoc
        * [version ?](http://johnmacfarlane.net/pandoc/)
* Web/Proxy
    * Apache2
        * [english 2.2](http://httpd.apache.org/docs/2.4/en/)
        * [português 2.2](http://httpd.apache.org/docs/2.4/pt-br/)
    * Varnish
        * [version 3.0](https://www.varnish-software.com/static/book/)
    * Nginx
        * [version 1.4.3](http://nginx.org/)
* Misc
    * Advanced Bash Script Guide
        * [version 6.6](http://www.tldp.org/LDP/abs/html/)
    * Guia FocaLinux
        * [version 6.43](http://www.guiafoca.org/)
    * Guia Expressões Regulares
        * [Index]()
root@rgoujob:/var/www/the-phpjs-local-docs-collection# php full-list.php 
* PHP
    * PHP
        * [english 5.3](http://www.php.net/manual/en/index.php)
        * [português 5.3](http://www.php.net/manual/pt_BR/index.php)
    * PHPUnit
        * [english](http://phpunit.de/manual/current/en/index.html)
        * [português](http://phpunit.de/manual/current/pt_br/index.html)
    * Yaml
        * [version 1.2](http://yaml.org/spec/1.2/spec.html)
    * Composer
        * [version ?](http://getcomposer.org/)
* JS
    * jQuery API
        * [version 1.9.x](http://api.jquery.com/)
    * jQuery UI
        * [Index](http://jqueryui.com/)
        * [API Docs](http://api.jqueryui.com/)
        * [Demos](http://jqueryui.com/demos/)
    * jQuery Plugins
        * [Datatables 1.9.4](http://datatables.net/'')
        * [Chosen 1.0.0](http://harvesthq.github.io/chosen/)
        * [jQuery File Upload](http://blueimp.github.io/jQuery-File-Upload/)
    * RequireJS
        * [version 2.1.8](requirejs.org)
    * AngularJS
        * [version 0.10.6](code.angularjs.org/)
    * BackboneJS
        * [version 1.0](http://backbonejs.org/)
    * UnderscoreJS
        * [version 1.5.2](http://underscorejs.org/)
    * NodeJS
        * [version 0.10.18](nodejs.org)
    * NPM Node Package Manager
        * [version 1.3.11](npmjs.org)
    * NodeJS Modules
        * [Swig Template Engine v1.0.0-rc2](http://paularmstrong.github.io/swig/)
        * [Jade Template Engine v0.35.0](jade-lang.com)
        * [Consolidate](https://npmjs.org/package/consolidate)
* Symfony
    * Symfony 2.x
        * [english 2.3](http://symfony.com/doc/current/index.html)
    * Doctrine 2 ORM
        * [Doctrine version 2.4](http://www.doctrine-project.org/docs/orm/2.4/en/index.html)
        * [Doctrine ODM version 2.0](http://www.doctrine-project.org/docs/orm/2.4/en/index.html)
        * [DBAL version 2.4](http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/index.html)
    * Twig
        * [version 1.13.0](twig.sensiolabs.org)
    * Symfony 1.4
        * [Index](http://symfony.com/legacy/doc)
    * Doctrine 1.2 ORM
        * [version 1.2](http://doctrine1.readthedocs.org/en/latest/)
    * SwiftMailer
        * [version 5.0.1](swiftmailer.org)
* Bootstrap
    * Twitter Bootstrap
        * [version 3.0](getbootstrap.com)
        * [version 2.3](http://getbootstrap.com/2.3.2/)
        * [Bootswatch Themes](bootswatch.com)
    * Twitter Bootstrap Plugins
        * [Font Awesome](fontawesome.io)
        * [FuelUX](http://exacttarget.github.io/fuelux/)
        * [Bootbox 2.3]()
        * [Bootbox 3.0](http://bootboxjs.com/)
        * [Datepicker](http://bootboxjs.com/)
        * [Sortable](http://johnny.github.io/jquery-sortable/)
        * [Typeahead Advanced](http://twitter.github.io/typeahead.js/)
* DB
    * MySQL Manual
        * [version 5.6](http://dev.mysql.com/doc/)
    * The MongoDB Manual
        * [version 2.4](http://docs.mongodb.org/manual/)
    * PostgreSQL
        * [version 9.1.9](http://www.postgresql.org/docs/9.2/static/)
    * SphinxSearch
        * [version 2.1.1 beta]()
* GIT
    * GIT Reference
        * [version ?](http://gitref.org/)
    * GIT Magic
        * [english](http://www-cs-students.stanford.edu/~blynn/gitmagic/)
        * [português](http://www-cs-students.stanford.edu/~blynn/gitmagic/intl/pt_br/)
* Doc Markups
    * reStructuredText
        * [Manual]()
        * [Sphinx reStructuredText](http://sphinx-doc.org/rest.html)
        * [CheatSheet 1]()
        * [CheatSheet 2]()
    * Sphinx-Pocoo
        * [Sphinx Site](http://sphinx-doc.org/)
        * [Sphinx Manual](http://sphinx-doc.org/contents.html)
        * [Sphinx Tutorial](http://sphinx-doc.org/tutorial.html)
    * Markdown Guide
        * [version ?](https://readthedocs.org/projects/markdown-guide/)
    * Pandoc
        * [version ?](http://johnmacfarlane.net/pandoc/)
* Web/Proxy
    * Apache2
        * [english 2.2](http://httpd.apache.org/docs/2.4/en/)
        * [português 2.2](http://httpd.apache.org/docs/2.4/pt-br/)
    * Varnish
        * [version 3.0](https://www.varnish-software.com/static/book/)
    * Nginx
        * [version 1.4.3](http://nginx.org/)
* Misc
    * Advanced Bash Script Guide
        * [version 6.6](http://www.tldp.org/LDP/abs/html/)
    * Guia FocaLinux
        * [version 6.43](http://www.guiafoca.org/)
    * Guia Expressões Regulares
        * [Index](http://aurelio.net/regex/)


## What languages?

Almost all English, some English and Portuguese, and just two great references only in Portuguese. 

## Licences

All docs are licensed to permit redistribuition. If for some reason I'd made a mistake, please let me 
know to exclude the doc. It's important to respect the authors.
