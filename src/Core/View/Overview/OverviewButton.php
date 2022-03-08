<?php
namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;

class OverviewButton extends ViewComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->class[] = 'overview__button';
        $this->tag = 'button';
    }

    public function getValue(string $key)
    {
        return $this->getParent()->getParent()->getModel()->get($key);
    }

}
