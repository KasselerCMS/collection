<?php

namespace Kasseler\Component\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface CollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
}