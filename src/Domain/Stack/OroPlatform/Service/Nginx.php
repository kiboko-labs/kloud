<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class Nginx implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return true;
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $servicesDependency = ['http-worker-prod', 'http-worker-dev'];
        if ($context->withXdebug) {
            $servicesDependency[] = 'http-worker-xdebug';
        }

        $stack->addServices(
            (new Service('http', 'nginx:alpine'))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                    new VolumeMapping('./.docker/nginx@1.15/config/reverse-proxy.conf', '/etc/nginx/conf.d/default.conf'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('cache', '/var/www/html/var/cache', true),
                    new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                )
                ->addPorts(
                    new PortMapping(new Variable('HTTP_PORT'), 80),
                )
                ->setRestartOnFailure()
                ->addDependencies(...$servicesDependency),
            (new Service('http-worker-prod', 'nginx:alpine'))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                    new VolumeMapping('./.docker/nginx@1.15/config/vhost-prod.conf', '/etc/nginx/conf.d/default.conf'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('cache', '/var/www/html/var/cache', true),
                    new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                )
                ->addPorts(
                    new PortMapping(new Variable('HTTP_PROD_PORT'), 80),
                )
                ->setRestartOnFailure()
                ->addDependencies('fpm'),
            (new Service('http-worker-dev', 'nginx:alpine'))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                    new VolumeMapping('./.docker/nginx@1.15/config/vhost-dev.conf', '/etc/nginx/conf.d/default.conf'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('cache', '/var/www/html/var/cache', true),
                    new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                )
                ->addPorts(
                    new PortMapping(new Variable('HTTP_DEV_PORT'), 80),
                )
                ->setRestartOnFailure()
                ->addDependencies('fpm')
            );

        $stack->addFiles(
            new Resource\InMemory('.docker/nginx@1.15/config/options.conf', <<<EOF
                client_header_timeout 10m;
                client_body_timeout 10m;
                send_timeout 10m;
                real_ip_header X-Forwarded-For;
                EOF),
            new Resource\InMemory('.docker/nginx@1.15/config/reverse-proxy.conf', <<<EOF
                upstream prod-app {
                    server http-worker-prod:80;
                }
                
                upstream dev-app {
                    server http-worker-dev:80;
                }
                
                upstream xdebug-app {
                    server http-worker-xdebug:80;
                }
                
                map \$http_x_symfony_env \$pool {
                     default "dev-app";
                     prod "prod-app";
                     dev "dev-app";
                     xdebug "xdebug-app";
                }
                
                server {
                     listen 80;
                     server_name _;
                     location / {
                          proxy_pass http://\$pool;
                
                          #standard proxy settings
                          proxy_set_header X-Real-IP \$remote_addr;
                          proxy_redirect off;
                          proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
                          proxy_set_header Host \$http_host;
                          proxy_redirect off;
                          proxy_set_header X-Forwarded-Proto \$scheme;
                          proxy_set_header X-NginX-Proxy true;
                          proxy_connect_timeout 600;
                          proxy_send_timeout 600;
                          proxy_read_timeout 600;
                          send_timeout 600;
                     }
                }
                EOF),
            new Resource\InMemory('.docker/nginx@1.15/config/vhost-dev.conf', <<<EOF
                server {
                    server_name _;
                    root /var/www/html/public;
                
                    index index_dev.php;
                
                    access_log /var/log/nginx/access_log;
                    error_log /var/log/nginx/error_log info;
                
                    try_files \$uri \$uri/ @rewrite;
                
                    location @rewrite {
                        rewrite ^/(.*)$ /index_dev.php/$1;
                    }
                
                    location ~ [^/].php(/|$) {
                        fastcgi_split_path_info ^(.+?.php)(/.*)$;
                
                        if (!-f \$document_root\$fastcgi_script_name) {
                            return 404;
                        }
                
                        fastcgi_index index_dev.php;
                        fastcgi_read_timeout 10m;
                        fastcgi_pass fpm:9000;
                        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
                        include fastcgi_params;
                    }
                }
                EOF),
            new Resource\InMemory('.docker/nginx@1.15/config/vhost-prod.conf', <<<EOF
                server {
                    server_name _;
                    root /var/www/html/public;
                
                    index index.php;
                
                    access_log /var/log/nginx/access_log;
                    error_log /var/log/nginx/error_log info;
                
                    try_files \$uri \$uri/ @rewrite;
                
                    location @rewrite {
                        rewrite ^/(.*)$ /index.php/$1;
                    }
                
                    location ~ [^/].php(/|$) {
                        fastcgi_split_path_info ^(.+?.php)(/.*)$;
                
                        if (!-f \$document_root\$fastcgi_script_name) {
                            return 404;
                        }
                
                        fastcgi_index index.php;
                        fastcgi_read_timeout 10m;
                        fastcgi_pass fpm:9000;
                        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
                        include fastcgi_params;
                    }
                }
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('HTTP_PORT')),
            new EnvironmentVariable(new Variable('HTTP_PROD_PORT')),
            new EnvironmentVariable(new Variable('HTTP_DEV_PORT')),
        );

        if ($context->withXdebug) {
            $stack->addServices(
                (new Service('http-worker-xdebug', 'nginx:alpine'))
                    ->addVolumeMappings(
                        new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                        new VolumeMapping('./.docker/nginx@1.15/config/vhost-xdebug.conf', '/etc/nginx/conf.d/default.conf'),
                        new VolumeMapping('./', '/var/www/html'),
                        new VolumeMapping('cache', '/var/www/html/var/cache', true),
                        new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                        )
                    ->addPorts(
                        new PortMapping(new Variable('HTTP_XDEBUG_PORT'), 80),
                        )
                    ->setRestartOnFailure()
                    ->addDependencies('fpm-xdebug'),
            );
            $stack->addEnvironmentVariables(
                new EnvironmentVariable(new Variable('HTTP_XDEBUG_PORT')),
            );
            $stack->addFiles(
                new Resource\InMemory('.docker/nginx@1.15/config/vhost-xdebug.conf', <<<EOF
                    server {
                        server_name _;
                        root /var/www/html/public;
                    
                        index index_dev.php;
                    
                        access_log /var/log/nginx/access_log;
                        error_log /var/log/nginx/error_log info;
                    
                        try_files \$uri \$uri/ @rewrite;
                    
                        location @rewrite {
                            rewrite ^/(.*)$ /index_dev.php/$1;
                        }
                    
                        location ~ [^/].php(/|$) {
                            fastcgi_split_path_info ^(.+?.php)(/.*)$;
                    
                            if (!-f \$document_root\$fastcgi_script_name) {
                                return 404;
                            }
                    
                            fastcgi_index index_dev.php;
                            fastcgi_read_timeout 10m;
                            fastcgi_pass fpm-xdebug:9000;
                            fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
                            include fastcgi_params;
                        }
                    }
                    EOF),
            );
        }

        return $stack;
    }
}