<?php

namespace Pars\Core\Application\Bootstrap;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Error\ErrorMiddleware;

class BootstrapApplication extends AbstractApplication
{
    protected function initPipeline()
    {
        foreach ($this->getApps() as $path => $appClass) {
            /* @var $app AbstractApplication */
            $app = $this->getContainer()->get($appClass);
            if (is_string($path)) {
                $this->pipe($path, $app);
            } else {
                $this->pipe($app);
            }
        }
    }

    protected function init()
    {
    }


    protected function getApps(): array
    {
        return $this->getConfig()->get('apps', []);
    }
}
