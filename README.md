# Github (team workflow)

Explico un poco desde el principio el workflow que tendremos en Github

1. Descargarse e instalarse git
2. Configurar en el git (username, password, etc)
3. Hacerle fork al repo https://github.com/edoomm/sistema-picking-web (un fork crea una copia del repositorio en tu GitHub)

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
Como les dije las branches sirven para ramificar el repo, por lo que traten de simular esto, es decir el nombre de una branch podría quedar de la siguiente manera: <br>
_feature1-feature1.1-feature1.1.1_
<br>
Otra donde podría estar trabajando alguien más podría ser <br>
_feature1-feature1.1-feature1.1.2_
<br>
E incluisve otra, donde puede estar trabajando otro equipo diferente puede ser <br>
_feature1-feature-2.1_

Por ejemplo una vez este la estructura, como trabajaremos la parte de _front end_, podríamos tener la branch principal _fend_ y a partir de esta, y dependiendo como se repartan el trabajo, podrían crear otras branches (ramificaciones) que desprendan de _fend_. Poniendo un ejemplo de como se podrían repartir el trabajo, quedaría algo así:

(Cada uno tendría que crear su branch y trabajar sobre ella)
- _fend-login_: @Gabriel
- _fend-menu_: @Kevin
- _fend-operador_ : @Raymundo
- _fend-operador-popup_ : @Esteban
- etc.

Una vez ya tengan completa su parte, ya dan pull request con `git push origin fend-feature`

## ¿Y todo esto pa qué?
Trabajar en branches, nos va a permitir estar trabajando al mismo tiempo, o cuando cada uno decida y no se tenga problemas por estar actualizando lo que otro ya hizo (para evitar conflictos con los `pull`)

Ya cuando alguien haya terminado y testeado la funcionalidad (_feature_) que está implementando, ya GitHub une casi automaticamente el trabajo que vayamos haciendo 

De forma gráfica, todo esto se vería así <br>
![branches!](https://lh3.googleusercontent.com/pw/ACtC-3c4jecBnWHSWTKeDl0RfC00AYSgamnod8uA0ljKFy2nkgy2eJ_75B05onW1xBXxljbXgNGOl1zU1oBUvz_F29FXrmR4wlBGKZVkgPUv-7NjGQ9cLRe41vJ0gCWfHLLq9V-oWLWVGPlcXRXzjjoEv_-c=w576-h521-no?authuser=0)

<br>

# No olviden
Llevar un estilo de programación similar al de todos, apoyense de recursos como [JSDocs](https://jsdoc.app/), [HTMLDocs](https://devdocs.io/html/) o [PHPManual](https://www.php.net/manual/en/index.php). Para que tengamos la misma nomenclatura en nuestras variables, funciones, etc.

Yo, como propietario del repo, podré ir viendo lo que vayan mandando, ir revisandolo y dandoles retro si algo esta mal