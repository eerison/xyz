up:
	docker-compose run --rm php composer install
	# docker-compose run --rm php php -S 0.0.0.0:8002 -t public
	docker run --rm -p 8003:8003 -v $(PWD):/app 3lever/php:8.1.7-cli-postgresql-dev php -S 0.0.0.0:8003 -t public