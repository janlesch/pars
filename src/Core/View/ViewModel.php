<?php
namespace Pars\Core\View;

use IteratorAggregate;
use SplDoublyLinkedList;
use Traversable;

class ViewModel implements IteratorAggregate
{
    protected string $value = '';

    protected ?SplDoublyLinkedList $list = null;

    public function push(ViewModel $model)
    {
        $this->getList()->push($model);
        return $this;
    }

    public function getList(): SplDoublyLinkedList
    {
        if (!isset($this->list)) {
            $this->list = new SplDoublyLinkedList();
        }
        return $this->list;
    }

    public function getIterator(): Traversable
    {
        return $this->list;
    }

    public function isList(): bool
    {
        return isset($this->list) && $this->list->count() > 0;
    }

    public function __get(string $name)
    {
        return $this->$name ?? '';
    }

    public function set(string $name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ViewModel
     */
    public function setValue(string $value): ViewModel
    {
        $this->value = $value;
        return $this;
    }


}