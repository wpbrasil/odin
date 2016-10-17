# Grunt.js #
> O Grunt é uma ferramenta capaz de automatizar diversas tarefas, como: concatenação, minificação e validação de arquivos, otimização de imagem, testes unitários, deploy de arquivos por ftp ou rsync, entre outras.

O Grunt vem integrado ao **Odin**, e para utilizá-lo é necessário ter instalado o [Node.js](http://nodejs.org/).

## Instalação Node ##

Clique [aqui](https://github.com/joyent/node/wiki/Installing-Node.js-via-package-manager) para instalar o Node na sua máquina.

## Instalação do Grunt ##

Com o Node instalado na sua máquina, você precisa instalar o Grunt. Execute o comando abaixo, para iniciar a instalação do Grunt.

```bash
$ sudo npm install -g grunt-cli
```

## Instalação dos pacotes do Grunt no Odin ##

Com o Grunt instalado, é hora de instalar as dependências responsáveis pela execução das tarefas do Grunt no seu projeto.

```bash
$ cd ROOT_PATH/wp-content/themes/odin/src/
$ sudo npm install
```

## Configuração no wp-config.php ##

Para usar os arquivos de JavaScript **não minificados** pelo *Grunt* você deve declarar a constante [SCRIPT_DEBUG](https://codex.wordpress.org/Debugging_in_WordPress#SCRIPT_DEBUG), em seu arquivo `wp-config.php`.

## Configuração no functions.php ##

Para usar a tarefa de LiveReload, pesquise no arquivo `functions.php` por: *watch livereload*, e logo abaixo descomente o seguinte código:

```php
wp_enqueue_script( 'odin-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true );
```

## Tarefas Disponíveis ##

*ATENÇÃO: Todos os comandos a seguir devem ser executados dentro da pasta `src`*.

### Compilar arquivos do Sass, minificar e validar scripts: ###

```bash
$ grunt
```

### Observar as mudanças no seu projeto ###

```bash
$ grunt watch
```

### Comprimir imagens na pasta `images/`: ###

```bash
$ grunt optimize
```

### Atualizar os arquivos do Bootstrap: ###

```bash
$ grunt bootstrap
```

### Fazer o deploy dos arquivos: ###

#### 1. via FTP ####

```bash
$ grunt ftp
```

#### 2. via rsync ####

```bash
$ grunt rsync
```
