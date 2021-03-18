Installation of the tool
===

Installing system-wide the `kloud` command
---

While installing system-wide, you will need administrator privilleges to install the command inside `/usr/local/bin/` directory.

```
sudo curl -L -o /usr/local/bin/kloud https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar
sudo curl -L -o /usr/local/bin/kloud.pubkey https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar.pubkey
sudo chmod +x /usr/local/bin/kloud
```

Installing the Phar package in your project
---

While installing in your project, no administrator privilege is required, the phar package will be available in the `bin/` directory.

```
curl -L -o bin/kloud.phar https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar
curl -L -o bin/kloud.phar.pubkey https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar.pubkey
chmod +x bin/kloud.phar
```

We also recommend to add both files to your `.gitignore` file.

If you want to use the pre-packaged docker image
---

If you do not want to install the command on your machine, a Docker image is ready for one-shot usages and can be executed this way:

```
docker run --rm -ti -v /var/run/docker.sock:/var/run/docker.sock \
    -v $HOME/.docker:/opt/docker/.docker \
    -v $PWD:/app \
    kiboko/kloud <command>
```
