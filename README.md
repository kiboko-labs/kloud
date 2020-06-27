Docker images and stacks for Oro and Marello development
===

This project aims at building your Docker stack for [OroCommerce](https://oroinc.com/b2b-ecommerce/), [OroCRM](https://oroinc.com/orocrm/), [OroPlatform](https://oroinc.com/oroplatform/) and [Marello](https://www.marello.com/) development.

> ⚠️ Nota: Those stacks are not suited for production hosting 

* [Installation](#installation)
* [Usage](#usage)
* [Tags](#tags)

Installation
---

### Installing system-wide the `kloud` command

While installing system-wide, you will need administrator privilleges to install the command inside `/usr/local/bin/` directory.

```
sudo curl -o /usr/local/bin/kloud https://github.com/kiboko-labs/docker-images/releases/download/1.0.2/kloud.phar
sudo curl -o /usr/local/bin/kloud.pubkey https://github.com/kiboko-labs/docker-images/releases/download/1.0.2/kloud.phar.pubkey
sudo chmod +x /usr/local/bin/kloud
```

### Installing the Phar package in your project

While installing in your project, no administrator privilege is required, the phar package will be available in the `bin/` directory.

```
curl -o bin/kloud.phar https://github.com/kiboko-labs/docker-images/releases/download/1.0.2/kloud.phar
curl -o bin/kloud.phar.pubkey https://github.com/kiboko-labs/docker-images/releases/download/1.0.2/kloud.phar.pubkey
chmod +x bin/kloud.phar
```

We also recommend to add both files to your `.gitignore` file.

### If you want to use the pre-packaged docker image

If you do not want to install the command on your machine, a Docker image is ready for one-shot usages and can be executed this way:

`docker run --rm -ti -v /var/run/docker.sock:/var/run/docker.sock -v $HOME/.docker:/opt/docker/.docker -v $PWD:/app kiboko/kloud <command>`

Usage
---

### Initialize your stack

In a new project, after cloning the original application repository, you can initialize the Docker stack configuration you will need.
You can invoke the following command that will guess what you need and a wizard will ask you a few questions about your preferences:

`kloud stack:init`

### Update your stack

In an existing project, you can upgrade the docker stack configuration. automagically.
You can invoke the following command that will guess what services needs to be updated and in case of differences, a wizard will ask you what you wish to keep or delete:

`kloud stack:update`

### Build the required images

If you need to build the images you need in a stack, you can execute the following command:

`kloud image:build`

### Test the required images

If you need to test if the images you are using are following every constraint you would expect:

`kloud image:test`

Supported versions and flavours
---

### With MySQL database backend

| Application    | Version | PHP 7.1         | PHP 7.2      | PHP 7.3         | PHP 7.4         | PHP 8.0         |
| -------------- | ------- | --------------- | ------------ | --------------- | --------------- | --------------- |
| OroPlatform CE | ^2.6.0  | ⚠️ discontinued | ❌           | ❌              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroPlatform EE | ^2.6.0  | ⚠️ discontinued | ❌           | ❌              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCRM CE      | ^2.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCRM EE      | ^2.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCommerce CE | ^1.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCommerce EE | ^1.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| Marello CE     | ^1.5.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^1.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^2.0    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.1    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.2    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^3.0    | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| Marello EE     | ^1.3.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^2.0    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.1    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.2    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^3.0    | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |

### With PostgreSQL database backend

| Application    | Version | PHP 7.1         | PHP 7.2      | PHP 7.3         | PHP 7.4         | PHP 8.0         |
| -------------- | ------- | --------------- | ------------ | --------------- | --------------- | --------------- |
| OroPlatform CE | ^2.6.0  | ⚠️ discontinued | ❌           | ❌              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
| OroPlatform EE | ^2.6.0  | ⚠️ discontinued | ❌           | ❌              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCRM CE      | ^2.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCRM EE      | ^2.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCommerce CE | ^1.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| OroCommerce EE | ^1.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^3.1.0  | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^4.1.0  | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| Marello CE     | ^1.5.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^1.6.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^2.0    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.1    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.2    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^3.0    | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
| Marello EE     | ^1.3.0  | ⚠️ discontinued | ❌           | ❌️              | ❌️              | ❌              |
|                | ^2.0    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.1    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^2.2    | ✅              | ✅           | ⚠️ experimental | ⚠️ experimental | ⚠️ experimental |
|                | ^3.0    | ❌              | ❌           | ✅️              | ✅️              | ⚠️ experimental |
