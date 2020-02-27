<?php

use Builder\Assert;
use Builder\Package\Repository;

$repository = new Repository('kiboko/php');

return [

    new Assert\BlackfireVersion($repository, '^1.31'),

    new Assert\XdebugVersion($repository, '^2.9'),

];