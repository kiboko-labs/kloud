<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class Redis implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->isEnterpriseEdition === true;
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('redis'))
                ->setBuildContext('.docker/redis@5/')
                ->addPorts(
                    new PortMapping(new Variable('REDIS_PORT'), 6379)
                )
                ->setRestartOnFailure(),
        );

        $stack->addFiles(
            new Resource\InMemory('.docker/redis@5/Dockerfile', <<<EOF
                FROM redis:5-alpine
                
                COPY redis.conf /usr/local/etc/redis/redis.conf
                
                CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]
                EOF
            ),
            new Resource\InMemory('.docker/redis@5/redis.conf', <<<EOF
                bind 0.0.0.0
                port 6379
                
                protected-mode yes
                
                tcp-backlog 511
                timeout 0
                tcp-keepalive 300
                
                daemonize no
                supervised upstart
                
                pidfile /var/run/redis_6379.pid
                
                loglevel notice
                logfile ""
                
                databases 16
                
                always-show-logo yes
                
                save 900 1
                save 300 10
                save 60 10000
                
                stop-writes-on-bgsave-error yes
                rdbcompression yes
                rdbchecksum yes
                dbfilename dump.rdb
                
                dir ./
                
                replica-serve-stale-data yes
                replica-read-only yes
                repl-diskless-sync no
                repl-diskless-sync-delay 5
                repl-disable-tcp-nodelay no
                replica-priority 100
                
                lazyfree-lazy-eviction no
                lazyfree-lazy-expire no
                lazyfree-lazy-server-del no
                replica-lazy-flush no
                
                appendonly no
                appendfilename "appendonly.aof"
                appendfsync everysec
                no-appendfsync-on-rewrite no
                auto-aof-rewrite-percentage 100
                auto-aof-rewrite-min-size 64mb
                aof-load-truncated yes
                aof-use-rdb-preamble yes
                
                lua-time-limit 5000
                
                slowlog-log-slower-than 10000
                slowlog-max-len 128
                
                latency-monitor-threshold 0
                
                notify-keyspace-events ""
                
                hash-max-ziplist-entries 512
                hash-max-ziplist-value 64
                list-max-ziplist-size -2
                list-compress-depth 0
                set-max-intset-entries 512
                zset-max-ziplist-entries 128
                zset-max-ziplist-value 64
                hll-sparse-max-bytes 3000
                stream-node-max-bytes 4096
                stream-node-max-entries 100
                activerehashing yes
                client-output-buffer-limit normal 0 0 0
                client-output-buffer-limit replica 256mb 64mb 60
                client-output-buffer-limit pubsub 32mb 8mb 60
                hz 10
                dynamic-hz yes
                aof-rewrite-incremental-fsync yes
                rdb-save-incremental-fsync yes
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('REDIS_PORT')),
        );

        return $stack;
    }
}