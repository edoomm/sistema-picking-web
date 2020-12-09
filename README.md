# Github (team workflow)

Explico un poco desde el principio el workflow que tendremos en Github

1. Descargarse e instalarse git
2. Configurar en el git (username, password, etc)
3. Hacerle fork al repo https://github.com/edoomm/sistema-picking-web (un fork crea una copia del repositorio en tu GitHub)

GitHub te permite trabajar un repositorio de manera local y actualizarlo de manera remota.

# Ya no vamos a usar branches jajaja
Ya únicamente con el **fork** que realicen, se creará una copia del repo en su cuenta
![fork!](https://lh3.googleusercontent.com/KcbVjC96CmdjCbK-4OuzcAkMluC_fZiYt1hJV1NXTlU5jG17RbqGwQp1LJ4A8XJ6czd335ddMa3ZSzt0XotWxCSSToJcSQVY6eCXZCZaDpnrSeWe04PTBhIveQuu7-d6wTpp95Vr4NqaqiwPuaoCPrUyCLE7yVuE9MO_Am8Rt3_De7YoqD1ERQ2MUdhP9wpJR3jHAfe0xx5cx8WrAFoZnP3V-rZc9C3qoiLTSvh3b7Imbo51Hn0kKrfm9J0yAHdmlkZtwRfVdGPp6-O5kKLxh34tV1VtJ19yfGFxkK9R2tMtybsAcvGEJ96CJPJA5ghnENh9GIbgsa6BmNH5-BsDHEWQQeg6pR_W_2XmRGyxQvw4DN3a_0tuFF4w9_Btwle_5k0s59ZoWbVN_LSScI-0IeJERaAytElysWllgTAzdbpy08xTP695jFkbh_EzDDXu14cS_Ubub4kLlZTrmLjQZxv0msj4bEYPtP7IgOm82Lz9E3ZiUGz8O9nBIsreipEyMMWPftehmZqKMvmqSgfABZcRM_df-Cb3PqcQo2jUkeA0w4lR6gKjQlY47Yf6yH6maH835t021nA7ZRs5eFEsVYZolJK4SNQ9-FvO66kIOJmAzRg2tiLXFg8fgQN12XGYvdA59KKFHyoP_Orq9yuqkQlqSH2Z1m6xxYb5-yniJbyuM-cNT1SbpjnZaU9i=w950-h290-no?authuser=0)
Y con esa copia en su cuenta ya pueden realizar todas las operaciones básicas de `git` (`add`, `commit`, `push`, `pull`) y se estará actualizando ahí en la copia del repositorio de su cuenta. 

Ya cuando hayan terminado de implementar x funcionalidad, haran un [pull request](https://docs.github.com/en/free-pro-team@latest/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request-from-a-fork) en el [repositorio original](https://github.com/edoomm/sistema-picking-web)
![pullrq!](https://docs.github.com/assets/images/help/pull_requests/pull-request-start-review-button.png)

Y ya prácticamente GitHub se encarga de hacer todo, para que se vaya juntando todo lo que hacemos.

# No olviden
Llevar un estilo de programación similar al de todos, apoyense de recursos como [JSDocs](https://jsdoc.app/), [HTMLDocs](https://devdocs.io/html/) o [PHPManual](https://www.php.net/manual/en/index.php). Para que tengamos la misma nomenclatura en nuestras variables, funciones, etc.

Yo, como propietario del repo, podré ir viendo lo que vayan mandando, ir revisandolo y dandoles retro si algo esta mal