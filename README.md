# Symfony 4 Twitter like Micro Blog application

### About Application
- App is based on PHP 7.2 and Symfony 4 framework
- DB in develop branch is **MySQL**
- App supports **[Docker](https://www.docker.com/)** development environment
- CI/CD is integrated with **[CircleCI](https://circleci.com/)**
- Integrated functionality of **import/export** micro blog posts

# CHECK ALSO USEFUL [APP DEMO SCREENS](https://github.com/Maksim1990/Symfony_APP_Twitter/blob/Build_app_guide/public/github/APP_GUIDE.md)

**HOT TO INSTALL APP**
--
     
* *Copy ``.env`` environment config file and set all required settings in it:*

    cp .env.dist .env
     
* *Start app and build required Docker containers:*

        docker-compose up -d
      
* *Install all composer dependencies:*

        docker exec -it twitterblog_php composer install

* *Run all required migrations:*

        docker exec -it twitterblog_php php bin/console doctrine:database:create
            
* *Run all required migrations:*

        docker exec -it twitterblog_php php bin/console doctrine:migrations:mig
  
      
* *Change permission for 'storage' folder:*
    
        docker exec -it twitterblog_php  chmod +x ./services/docker/set_storage_read_write_permissions.sh
        docker exec -it twitterblog_php  ./services/docker/set_storage_read_write_permissions.sh

App is available on ``8310`` port
--
    http://127.0.0.1:8310
