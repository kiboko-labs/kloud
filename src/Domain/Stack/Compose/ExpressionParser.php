<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

final class ExpressionParser
{
    public function parse(string $value): Expression
    {
        $offset = 0;
        $length = strlen($value);
        $elements = [];
        while ($offset < $length) {
            if (false === preg_match('/([^$]*)(?:\\$\\{([^}]+)\\}|\\$([a-zA-Z0-9_-]+))?/', $value, $matches, 0, $offset)) {
                break;
            }

            if (strlen($matches[1]) > 0) {
                $elements[] = $matches[1];
            }

            if (isset($matches[3])) {
                $elements[] = new Variable($matches[3]);
            } else if (isset($matches[2])) {
                $elements[] = new Variable($matches[2]);
            }

            $offset += strlen($matches[0]);
        }

        return new Expression(...$elements);
    }
}