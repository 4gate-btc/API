composer update

wait.sh api_postgres:5432 -- symfony console doctrine:database:create --if-not-exists
wait.sh api_postgres:5432 -- symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration
wait.sh api_postgres:5432 -- symfony console doctrine:database:create --if-not-exists --env=test
wait.sh api_postgres:5432 -- symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration --env=test