<?php
namespace Pars\Core\View\Overview;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;
use SplDoublyLinkedList;

class Overview extends ViewComponent
{
    public string $toolbar = '';
    protected SplDoublyLinkedList $buttons;
    protected ViewComponent $thead;
    protected ViewComponent $tbody;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/overview.phtml');
        $this->buttons = new SplDoublyLinkedList();
        $this->thead = create(ViewComponent::class);
        $this->tbody = create(ViewComponent::class);
        $this->thead->setTemplate(__DIR__ . '/templates/overview_head.phtml');
        $this->tbody->setTemplate(__DIR__ . '/templates/overview_body.phtml');
        $this->push($this->thead);
        $this->push($this->tbody);
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if (!$this->tbody->getModel()->isList()) {
            $this->children = new SplDoublyLinkedList();
        }
    }


    public function getButtons(): SplDoublyLinkedList
    {
        return $this->buttons;
    }

    public function addButton(string $name): OverviewButton
    {
        $button = create(OverviewButton::class);
        $button->setContent($name);
        $this->buttons->push($button);
        return $button;
    }

    public function addIconButton(Icon $icon): OverviewButton
    {
        $button = create(OverviewButton::class);
        $button->push($icon);
        $this->buttons->push($button);
        return $button;
    }


    public function addField(string $key, string $name = ''): OverviewField
    {
        $field = create(OverviewField::class, $key, $name);
        $this->thead->push($field);
        $this->tbody->push($field);
        return $field;
    }

    public function addEntry(ViewModel $model): static
    {
        $this->tbody->getModel()->push($model);
        return $this;
    }

    /**
     * @return string
     */
    public function getToolbar(): string
    {
        return $this->toolbar;
    }

    /**
     * @param string $toolbar
     * @return Overview
     */
    public function setToolbar(string $toolbar): Overview
    {
        $this->toolbar = $toolbar;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     * @return Overview
     */
    public function setHeading(string $heading): Overview
    {
        $this->heading = $heading;
        return $this;
    }


}