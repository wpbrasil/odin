## Comandos

O Odin utiliza o [Gulp][gulp] para automatizar suas tarefas. Tenha certeza de ter os [requisitos](#requisitos) instalados antes de usa-lo.

| Comando          | Descrição                                                                                  |
| ---              | ---                                                                                        |
| `$ gulp`         | Compila todos os arquivos. `src/*` para `assets/`                                          |
| `$ gulp start`   | Compila todos os arquivos, inicia _serve_ e assiste alterações em arquivos.                |
| `$ gulp dist`    | Gera arquivos para ser distríbudos. `/dist`.                                               |
| `$ gulp docs`    | Gera documentação em HTML. `src/docs` para `assets/docs`.                                  |
| `$ gulp scripts` | Valida e compila arquivos JS. `src/js` para `assets/js`                                    |
| `$ gulp styles`  | Compila arquivos SASS/SCSS para CSS `src/scss` para `assets/css`                           |
| `$ gulp images`  | Otimiza arquivos imagens JPG, PNG e GIF. `src/img` para `assets/img`                       |
| `$ gulp fonts`   | Compila arquivos fonts. `src/fonts` para `assets/fonts`.                                   |
