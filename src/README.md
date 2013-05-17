## Grunt.js ##

Para usar o **Odin** com o Grunt.js é necessário ter instalado o [Node.js](http://nodejs.org/).

## Instalação Node.js ##

* [Instalação do Node.js](https://github.com/joyent/node/wiki/Installing-Node.js-via-package-manager)

## Instalação do Grunt.js ##

    $ sudo npm install -g grunt-cli

## Instalação dos pacotes do Grunt.js no Odin ##

    $ cd ROOT_PATH/wp-content/themes/odin/src/
    $ sudo npm install

## Configuração no functions.php ##

Para usar os arquivos de JavaScript comprimidos pelo Grunt.js você deve ativar esse suporte no `functions.php` do **Odin** da seguinte forma:

    define( 'ODIN_GRUNT_SUPPORT', true );

## Comandos ##

*ATENÇÃO: Todos os comandos a seguir devem ser executados dentro da pasta `src`*.

Compilar arquivos do SASS e JavaScripts:

    $ grunt

Fazer o Grunt.js assistir o seu projeto:

    $ grunt watch

Comprimir todas as imagens da pasta `images/`:

    $ grunt imagemin

Atualizar os arquivos do Twitter Bootstrap:

    $ grunt bootstrap
