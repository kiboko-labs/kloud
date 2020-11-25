Usage
===

Initialize your stack
---

In a new project, after cloning the original application repository, you can initialize the Docker stack configuration you will need.
You can invoke the following command that will guess what you need and a wizard will ask you a few questions about your preferences:

`kloud stack:init`

Once the command is finished, you will have a file named `.env.dist` containing the required environment variables for the stack.
This file has to be renamed to `.env` in order to be used by Docker Compose.
The command have set some ports values for all services, you may wish to change them depending on your environment.

#Available command line options
---

* Database engine selection
  * `--mysql`: Set up the application to use MySQL.
  * `--postgresql`: Set up the application to use PostgreSQL.

* Xdebug a debugger for PHP
  * `--with-xdebug`: Set up the application to use Xdebug.
  * `--without-xdebug`: Set up the application without Xdebug.

* Blackfire an APM for PHP performance optimizations
  * `--with-blackfire`: Set up the application to use Blackfire.
  * `--without-blackfire`: Set up the application without Blackfire.

* Dejavu, An ElasticSearch UI
  * `--with-dejavu`: Set up the application to use Dejavu UI.
  * `--without-dejavu`: Set up the application without Dejavu UI.

* Elastic Stack for application logging
  * `--with-elastic-stack`: Set up the application to use Elastic Stack logging.
  * `--without-elastic-stack`: Set up the application without Elastic Stack logging.

* Mac OS optimizations on data volumes
  * `--with-macos-optimizations`: Set up the application to use Docker for Mac optimizations.
  * `--without-macos-optimizations`: Set up the application without Docker for Mac optimizations.

Update your stack
---

In an existing project, you can upgrade the docker stack configuration. automagically.
You can invoke the following command that will guess what services needs to be updated and in case of differences, a wizard will ask you what you wish to keep or delete:

`kloud stack:update`

Build the required images
---

If you need to build the images you need in a stack, you can execute the following command:

`kloud image:build`

To enable experimental images, you will need to add option `--with-experimental`.
  
Test the required images
---

If you need to test if the images you are using are following every constraint you would expect:

`kloud image:test`

Environment commands
---

After `kloud stack:init`, you can use several environment commands to do several things on a remote server

* `kloud environment:init`: Initialize the environment file in local workspace.
* `kloud environment:variable:add`: Add an environment variable.
* `kloud environment:variable:unset`: Unset an environment variable value.
* `kloud environment:variable:get`: Print an environment variable value.
* `kloud environment:variable:set`: Change an environment variable value.
* `kloud environment:variable:list`: Print the list of environment variables and their value.
* `kloud environment:deploy`: Deploy the application to a remote server using rsync and initialize docker services.
* `kloud environment:destroy`: Destroy the docker infrastructure with associated volumes and remove remote directory.
* `kloud environment:start`: Start docker services on the remote server.
* `kloud environment:stop`: Stop docker services on the remote server.
* `kloud environment:rsync`: Synchronize remote directory according to local directory.
* `kloud environment:cache:clear`: SClear cache and restart FPM service.
* `kloud environment:database:dump`: Dump the database in the current state.
* `kloud environment:database:load`: Load a database dump.
* `kloud environment:shell`: Start a shell session for a service.
