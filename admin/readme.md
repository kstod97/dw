# Rodando no ubuntu

php -S localhost:8000

# Rodado o mysql

docker run --name mysql-local \
  -v ./SQL:/docker-entrypoint-initdb.d \
  -e MYSQL_ALLOW_EMPTY_PASSWORD=yes \
  -e MYSQL_DATABASE=car_rent \
  -p 3306:3306 \
  -d mysql:8

# Verificando se as tabelas foram criadas

docker exec -it mysql-local mysql -uroot -e "USE car_rent; SHOW TABLES;"