<?php
namespace Framework;

abstract class Collection implements \IteratorAggregate, \Countable
{
    protected $items = array();

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function count()
    {
        return count($this->items);
    }
}