### Install Symfony CLI
```
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E 
sudo apt install symfony-cli
```

### Create New Symfony Applications
```
symfony new my_project
symfony new --webapp my_project
symfony new my_project_directory --version="6.1.*" --webapp
```

### Creating Symfony Applications with composer
```
composer create-project symfony/skeleton:"6.1.*" my_project_directory
```

### Running Symfony Applications
```
symfony server:start
symfony server:start --no-tls
```

### Installing Packages
```
composer require annotations
composer require twig
composer require symfony/asset
composer require --dev symfony/maker-bundle
composer require symfony/orm-pack
composer require sensio/framework-extra-bundle
composer require --dev orm-fixtures
```

### The bin/console Command
```
php bin/console debug:router
php bin/console debug:router app_lucky_number
php bin/console debug:autowiring
php bin/console router:match /lucky/number/8
php bin/console make:controller BrandNewController
php bin/console make:entity
php bin/console make:entity --regenerate
php bin/console make:migration
php bin/console doctrine:database:create
php bin/console doctrine:database:drop --force
php bin/console doctrine:migrations:migrate
php bin/console list make
php bin/console dbal:run-sql 'SELECT * FROM product',
php bin/console make:fixtures CustomerFixtures
php bin/console doctrine:fixtures:load
```

### Build and push a Docker images to a container registry
```sh
docker build -t kurtay/nginx:sym-tut -f ./nginx/Dockerfile .
docker build -t kurtay/php:sym-tut -f ./php/Dockerfile .
docker image push kurtay/nginx:sym-tut
docker image push kurtay/php:sym-tut
```

### Creating AWS Elastic Kubernetes Cluster
```sh
cd aws-eks
terraform init
terraform plan
terraform apply --auto-approve
terraform destroy --auto-approve
```

### AWS Deployment
```sh
cd k8s-deployment
aws eks --region eu-central-1 update-kubeconfig --name <cluster-name>
kubectl get svc
kubectl apply -f deployment.yml
kubectl apply -f service.yml
kubectl get deploy,svc,pods
```