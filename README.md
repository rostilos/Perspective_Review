A module developed as part of a roadmap implementation that adds custom functionality for posting reviews on the product page

## Module Installation
```
composer config repositories.perspective-magento2-rewiew git git@github.com:rostilos/Perspective_Review.git
composer require perspective/magento2-rewiew dev-master

php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
php bin/magento cache:clean
```
## Module Settings : 
Stores -> Configuration -> Perspective -> Perspective Review
![2023-08-10_13-56](https://github.com/rostilos/Perspective_Reviews/assets/85498741/feb36f8b-08e0-4c4a-9296-ef9e81bc7201)


## List of all reviews posted : 
![2023-08-10_14-00](https://github.com/rostilos/Perspective_Reviews/assets/85498741/4dc71ad7-6d1e-4edb-a9f4-3fcc8a7b5cb2)

## GrapgQl module : 
https://github.com/rostilos/Perspective_ReviewGraphQl
