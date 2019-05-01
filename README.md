# Symfony 4 Twitter like Micro Blog application

### About Application
- App is based on PHP 7.2 and Symfony 4 framework
- DB in develop branch is **MySQL**
- Full app development is proceeded in **[Laradock](https://laradock.io/)** environment 
- CI/CD is integrated with **[CircleCI](https://circleci.com/)**
- Integrated functionality of **import/export** micro blog posts

# CHECK ALSO USEFUL [APP DEMO SCREENS](https://github.com/Maksim1990/Symfony_APP_Twitter/blob/Build_app_guide/public/github/APP_GUIDE.md)

### How To Run App in **Laradock** environment

1) Start Laradock

```
docker-compose up -d php-fpm workspace mysql nginx
```

2) Enter in running application container

```
docker exec -it laradock_workspace_1 bash 
```

3) Navigate to app folder and run app following command for setup application
```
cd [YOUR_APP_PATH]
php bin/console doctrine:database:create
php bin/console doctrine:migrations:mig
```
