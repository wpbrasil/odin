## Comandos

O Odin utiliza o [Gulp][gulp] para automatizar suas tarefas. Tenha certeza de ter os [requisitos][odin-prereq] instalados antes de usa-lo.

| Comando          | Descrição                                                                                                           |
| ---              | ---                                                                                                                 |
| `$ gulp`         | Compila todos os arquivos. `src/*` para `assets/`                                                                   |
| `$ gulp start`   | Compila arquivos, inicia _serve_ e assiste alterações. **Obs:** Configurar `config['proxy']` em `gulpfile.js`.      |
| `$ gulp dist`    | Gera arquivos para ser distríbudos. `/dist`.                                                                        |
| `$ gulp scripts` | Valida e compila arquivos JS. `src/js` para `assets/js`                                                             |
| `$ gulp styles`  | Compila arquivos SASS/SCSS para CSS `src/scss` para `assets/css`                                                    |
| `$ gulp images`  | Otimiza arquivos imagens JPG, PNG e GIF. `src/img` para `assets/img`                                                |
| `$ gulp fonts`   | Compila arquivos fonts. `src/fonts` para `assets/fonts`.                                                            |
| `$ gulp watch`   | Assiste alterações em arquivos.                                                                                     |

[gulp]: http://gulpjs.com
[odin-prereq]: https://github.com/adammacias/odin/tree/v3-gh-pages/v3-prereq
