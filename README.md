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

To use API: 
* call to localhost:8080/send via POST method.
* it requires data in json format and structure
```json
{
	"text":"some message",
	"destination":[{
		"identifier":"+7(952)0-98-0877",
		"messanger":"Telegram"
	},{
		"identifier":"9520980877",
		"messanger":"Viber"
	}]
}
```
For the development Zend Framework was used. 
The reason for it was that I used to it and review\studying different would take too much time.
RabbitMQ was used to achieve asynchronysity so message resending would not affect other requests.
