# Laravel API with DockerSetup
A go to working API for Laravel Enthusists. This API features the go to set-up to start your API development. Build with latest version of Laravel (11.x) this project was develop to bootstrap any API project from scratch.

This project has role-based authentication system. With easy to setup structure. If you're planning to setup a API for your project in laravel. This is the easy way to go.

Also as it is docker setup so you can easily deploy on your server with the pre-build docker file (Configure based on your needs)

----

## Run the Project
Docker must be installed in the system.

- Run the docker setup.
- Open the terminal inside the project and run the command 
`docker-compose up` 
    This will run the containers with php server and frontend and db all together.
- To make any comman inside the project open the shell inside docker first by executing 
`docker-compose exec backend sh` 
and artisan commands can be run in the shell.

----
