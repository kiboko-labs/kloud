Docker images and stacks for Oro and Marello development
===

This project aims at building your Docker stack for [OroCommerce](https://oroinc.com/b2b-ecommerce/), [OroCRM](https://oroinc.com/orocrm/), [OroPlatform](https://oroinc.com/oroplatform/) and [Marello](https://www.marello.com/) development.

> ⚠️ Nota: Those stacks are not suited for production hosting 

* [Installation](#installation)
* [Usage](#usage)
* [Supported versions and flavors](#supported-versions-and-flavours)
  * [OroPlatform](#oroplatform)
  * [OroCRM](#orocrm)
  * [OroCommerce](#orocommerce)
  * [Marello](#marello)
  * [Middleware](#middleware)

Installation
---

### Installing system-wide the `kloud` command

While installing system-wide, you will need administrator privilleges to install the command inside `/usr/local/bin/` directory.

```
sudo curl -L -o /usr/local/bin/kloud https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar
sudo curl -L -o /usr/local/bin/kloud.pubkey https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar.pubkey
sudo chmod +x /usr/local/bin/kloud
```

### Installing the Phar package in your project

While installing in your project, no administrator privilege is required, the phar package will be available in the `bin/` directory.

```
curl -L -o bin/kloud.phar https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar
curl -L -o bin/kloud.phar.pubkey https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar.pubkey
chmod +x bin/kloud.phar
```

We also recommend to add both files to your `.gitignore` file.

### If you want to use the pre-packaged docker image

If you do not want to install the command on your machine, a Docker image is ready for one-shot usages and can be executed this way:

```
docker run --rm -ti -v /var/run/docker.sock:/var/run/docker.sock \
    -v $HOME/.docker:/opt/docker/.docker \
    -v $PWD:/app \
    kiboko/kloud <command>
```

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

### OroPlatform

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.8    | 🌅️      | ❌      | ❌      | ❌      | ❌️      | ❌      |
| ^1.10   | 🌅️      | ❌      | ❌      | ❌      | ❌️      | ❌      |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.12   | 🌅️      | ❌      | ❌      | ❌      | ❌️      | ❌      |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### OroCRM

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### OroCommerce

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### Marello

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.5    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^2.0    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.2    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^3.0    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.5    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^2.0    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.2    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^3.0    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### Middleware

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.0    | ❌      | ❌      | ❌      | ❌️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.0    | ❌      | ❌      | ❌      | ❌️      | ✅️      | ⚠️      |
