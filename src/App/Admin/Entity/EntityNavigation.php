<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Navigation\Navigation;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

class EntityNavigation extends Navigation
{
    public function addTypeSubmenu(string $type = Entity::TYPE_TYPE, string $context = Entity::CONTEXT_DEFINITION)
    {
        $repo = new EntityRepository();
        $filterEntity = new Entity();
        $filterEntity->clear();
        $filterEntity->setCode(Entity::CONTEXT_DEFINITION);
        $filterEntity->setType(Entity::TYPE_CONTEXT);
        $entity = $repo->find($filterEntity)->current();
        if (null === $entity) {
            return;
        }
        $submenu = $this->addEntry(
            $entity->getNameFallback(),
            url('/entity', [Entity::TYPE_CONTEXT => $context])
        );
        $filterEntity = new Entity();
        $filterEntity->clear();
        $filterEntity->setContext(Entity::CONTEXT_DEFINITION);
        $filterEntity->setType($type);
        foreach ($repo->find($filterEntity) as $entity) {
            /** @var Entity $entity */
            $submenu->addEntry(
                $entity->getNameFallback(),
                url('/entity', ['type' => $entity->getCode(), 'context' => $context])
            );
        }
    }
    
    public function addType(string $type = Entity::TYPE_DATA, string $context = Entity::CONTEXT_DATA)
    {
        $repo = new EntityRepository();
        $filterEntity = new Entity();
        $filterEntity->clear();
        $filterEntity->setContext(Entity::CONTEXT_DEFINITION);
        $filterEntity->setType($type);
        foreach ($repo->find($filterEntity) as $entity) {
            /** @var Entity $entity */
            $this->addEntry(
                $entity->getNameFallback(),
                url('/entity', ['type' => $entity->getCode(), 'context' => $context])
            );
        }
    }
}