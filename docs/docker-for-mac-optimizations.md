Docker for Mac optimizations
===

Regarding Mac installations, we have made some optimizations by mounting the following directories in the stack:
* `/var/www/html/var/cache`
* `/var/www/html/public/bundles`
* `/opt/docker/.composer/`

Those are directories that needs a fast I/O access in order to make the application work fast on Macintosh.

Benchmarking
---

We are using image `kiboko/php:7.4-cli-orocommerce-ee-4.1-postgresql` in this benchmark, starting with the following declaration:

```yaml
version: '2.2'
services:
    sh:
        image: 'kiboko/php:7.4-cli-orocommerce-ee-4.1-postgresql'
        user: 'docker:docker'
        environment:
            - COMPOSER_AUTH
            - COMPOSER_PROCESS_TIMEOUT
        volumes:
            - '${HOME}/.ssh:/opt/docker/.ssh/'
            - './:/var/www/html'
        command:
            - sleep
            - '31536000'
        restart: on-failure
```

> ⚠️ Nota: All the following tests were made with a Macbook Pro (15 inch, 2019) with 2,6 GHz Intel Core i7 and 32 Go 2400 MHz DDR4.

We run a command on the host system to measure the raw performances of the filesystem:

```bash
$ time dd if=/dev/zero of=test.dat bs=1024 count=100000
100000+0 records in
100000+0 records out
102400000 bytes transferred in 0.339715 secs (301429136 bytes/sec)

real    0m0.362s
user    0m0.049s
sys     0m0.300s
```

Then, we connect to the container and stress the filesystem inside a standard container:

```bash
$ docker-compose run --rm sh /bin/sh
/var/www/html $ time dd if=/dev/zero of=test.dat bs=1024 count=100000
100000+0 records in
100000+0 records out
real    0m 25.41s
user    0m 0.20s
sys     0m 3.64s
```

This is our initial performances of a stack without any optimizations. The conainer is more than 70 times slower than the host. This is not acceptable, we will obviously need a better speed to be able to work with this stack.

We will do some changes in the directories that are frequently stressed, by using a `tmpfs` mount:

```yaml
services:
    sh:
        volumes:
            # ...
            - 'cache:/var/www/html/var/cache'
            - 'assets:/var/www/html/public/bundles'
            - 'composer:/opt/docker/.composer/'
volumes:
    composer:
        driver: local
        driver_opts:
            type: tmpfs
            device: tmpfs
            o: 'size=2048m,uid=1000,gid=1000'
    assets:
        driver: local
        driver_opts:
            type: tmpfs
            device: tmpfs
            o: 'size=2048m,uid=1000,gid=1000'
    cache:
        driver: local
        driver_opts:
            type: tmpfs
            device: tmpfs
            o: 'size=2048m,uid=1000,gid=1000'
```


```bash
$ docker-compose run --rm sh /bin/sh
/var/www/html $ cd var/cache/
/var/www/html/var/cache $ time dd if=/dev/zero of=test.dat bs=1024 count=100000
100000+0 records in
100000+0 records out
real    0m 0.20s
user    0m 0.07s
sys     0m 0.13s
```

We can now see our cache directory, mounted as a `tmpfs` is way faster
than what we used to have, it is even faster than our standard nvme 
hard drive of the host.
