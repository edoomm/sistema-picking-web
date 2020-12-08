# Github (team workflow)

Explico un poco desde el principio el workflow que tendremos en Github

1. Descargarse e instalarse git
2. Configurar en el git (username, password, etc)
3. Hacerle fork al repo https://github.com/edoomm/sistema-picking-web (un fork crea una copia del repositorio en tu GitHub)
4. 2.5. Pero antes de hacerle fork ya debe de haber algo en el repo, @Kevin ya solo es que cree la estructura de las páginas con los links, para toda la parte de navegación

GitHub te permite trabajar un repositorio de manera local y actualizarlo de manera remota.

# Branches

Los branches sirven para ramificar el repo y que todos puedan estar desarrollando al mismo tiempo distintas funcionalidades, por eso que de ahi @Kevin necesita hacer la estructura, para que todos tengan eso como base y ya puedan trabajar en su respectiva página y la pongan bonita y así

- Para crear branches utilizan <br>
`git checkout -b [nombre-branch]`
- Para cambiarse a una branch existente <br>
`git checkout [nombre-branch]`
- Para ver los branches que existen de manera local <br>
`git branch`
- Para ver los branches remotos <br>
`git branch -r`

Una vez que ya esten en la branch correcta, ya pueden realizar todas las operaciones básicas de `git` (`add`, `commit`, `push`, `pull`)

Para el caso del push, tal como viene en la [cheatsheet](https://education.github.com/git-cheat-sheet-education.pdf) oficial de GitHub

> `git push [alias] [branch]`

Un ejemplo para dar un push al repo remoto (que sería el que más utilizaríamos) <br>
`git push origin fend-feautre`

## Nomenclatura de branches
Como les dije las branches sirven para ramificar el repo, por lo que traten de simular esto, es decir el nombre de una branch podría quedar de la siguiente manera:
_feature1-feature1.1-feature1.1.1_

Por ejemplo una vez este la estructura, como trabajaremos la parte de _front end_, podríamos tener la branch principal _fend_ y a partir de esta, y dependiendo como se repartan el trabajo, podrían crear otras branches (ramificaciones) que desprendan de _fend_. Poniendo un ejemplo de como se podrían repartir el trabajo, quedaría algo así:

(Cada uno tendría que crear su branch y trabajar sobre ella)
- _fend-login_: @Gabriel
- _fend-menu_: @Kevin
- _fend-operador_ : @Raymundo
- etc.

Una vez ya tengan completa su parte, ya dan pull request con `git push origin fend-feature`