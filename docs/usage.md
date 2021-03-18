Usage in your Oro-family projects
===

What do you need before starting?
---

* Optionally an existing directory with an Oro-family application sources.
* the `kloud` command available in one of the ways described in the [Installation](installation.md) instructions

Initialize your stack
---

In a new project, after cloning the original application repository, you can initialize the Docker stack configuration you will need.
You can invoke the following command that will guess what you need and a wizard will ask you a few questions about your preferences:

`kloud stack:init`

Once the command is finished, you will have a file named `.env.dist` containing the required environment variables for the stack.
This file has to be renamed to `.env` in order to be used by Docker Compose.
The command have set some ports values for all services, you may wish to change them depending on your environment.

### Additional command line options

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

Upgrade your stack
---

In an existing project, you can upgrade the docker stack configuration automagically.
You can invoke the following command that will guess what services needs to be updated 
and in case of differences, a wizard will ask you what you wish to keep or delete:

`kloud stack:upgrade`

> Update the Docker stack in a project

Build the required images
---

In hte case you are using a [sunsetting or experimental version combination](sunsetting-policy.md),
you will need to build yourself the images. Any other version will be auomatically built and pushed
to Docker Hub, without the need for you to build them yourself.

Build all necessary images, you need to execute the following command:

`kloud image:build`

In case you are using experimental images, you will need to add the additional option `--with-experimental`.
  
Test the required images
---

If you need to test if the images you are using are following every constraint you would expect:

`kloud image:test`

Environment commands
---

After `kloud stack:init`, you can use the environment commands to do various actions on your local
machine or a remote server.

### Initialize an environment

* `kloud environment:init`: Initialize the environment file in local workspace.

### Environment variables

* `kloud environment:variable:add`: Add an environment variable.
* `kloud environment:variable:unset`: Unset an environment variable value.
* `kloud environment:variable:get`: Print an environment variable value.
* `kloud environment:variable:set`: Change an environment variable value.
* `kloud environment:variable:list`: Print the list of environment variables and their value.

### Deploy environment

* `kloud environment:deploy`: Deploy the application to a remote server using rsync and initialize docker services.

### Destroy the environment

* `kloud environment:destroy`: Destroy the docker infrastructure with associated volumes and remove remote directory.

### Start the environment's services

* `kloud environment:start`: Start docker services on the remote server.

### Stop the environment's services

* `kloud environment:stop`: Stop docker services on the remote server.

### Synchronize your local sources with the remote

* `kloud environment:rsync`: Synchronize remote directory according to local directory.

### Clear the Symfony cache

* `kloud environment:cache:clear`: SClear cache and restart FPM service.

### Dump the database from your environment

* `kloud environment:database:dump`: Dump the database in the current state.

### Load a database dump into your environment

* `kloud environment:database:load`: Load a database dump.

### Open a shell in the environment

* `kloud environment:shell`: Start a shell session for a service.
