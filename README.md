# Projet symfony LP AW
* Installation des dépendances php :
`composer install`

* Installation des dépendances node :
`yarn install`

* Generer les fichiers css et js :
`yarn run encore dev`
ou
`yarn run encore dev --watch`

* Charger les fixtures
`php bin/console doctrine:fixtures:load`
ou
`php bin/console fixtures:load --append`