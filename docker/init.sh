composer update

wait.sh postgres:5432 -- symfony console doctrine:database:create --if-not-exists
wait.sh postgres:5432 -- symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration
wait.sh postgres:5432 -- symfony console doctrine:database:create --if-not-exists --env=test
wait.sh postgres:5432 -- symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration --env=test