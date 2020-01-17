# Test Application done for 404group
ToDo: delayed messages
ToDo: tests

## by Aleksei Kochetkov

# installation guide
* clone repository
* navigate to it via Power shell
* docker-compose up
* docker exec -it test404-server composer install
* docker exec -it test404-server vendor/bin/phinx migrate
* docker exec -it test404-server php public/index.php message-sender


For the development Zend Framework was used. The reason for it was that I used to it.