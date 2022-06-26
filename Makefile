up:
	docker-compose run --rm php composer setup
	docker-compose up -d
	echo "The api is available here: http://localhost:8003/api :)"
