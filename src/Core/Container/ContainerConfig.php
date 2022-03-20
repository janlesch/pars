<?php

namespace Pars\Core\Container;

use Pars\Core\Config\{Config, ConfigFactory};
use Pars\Core\Error\NotFound\NotFoundHandler;
use Pars\Core\Error\NotFound\NotFoundHandlerFactory;
use Pars\Core\Http\HttpFactory;
use Pars\Core\Log\{Log, LogFactory};
use Pars\Core\Pipeline\BasePath\{BasePathMiddleware, BasePathMiddlewareFactory};
use Psr\Log\LoggerInterface;
use Psr\Http\Message\{RequestFactoryInterface,
    ResponseFactoryInterface,
    ServerRequestFactoryInterface,
    StreamFactoryInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface,
};

class ContainerConfig
{
    private Config $config;
    private array $factories;

    public function getFactories(): array
    {
        if (!isset($this->factories)) {
            $this->factories = $this->loadFactories();
        }
        return $this->factories;
    }

    protected function getDefaultFactories(): array
    {
        return [
            Log::class => LogFactory::class,
            LoggerInterface::class => LogFactory::class,
            Config::class => ConfigFactory::class,
            RequestFactoryInterface::class => HttpFactory::class,
            ResponseFactoryInterface::class => HttpFactory::class,
            ServerRequestFactoryInterface::class => HttpFactory::class,
            StreamFactoryInterface::class => HttpFactory::class,
            UploadedFileFactoryInterface::class => HttpFactory::class,
            UriFactoryInterface::class => HttpFactory::class,
            HttpFactory::class => HttpFactory::class,
            BasePathMiddleware::class => BasePathMiddlewareFactory::class,
            NotFoundHandler::class => NotFoundHandlerFactory::class
        ];
    }

    private function loadFactories(): array
    {
        return array_replace_recursive(
            $this->getDefaultFactories(),
            $this->getConfig()->get('factories', [])
        );
    }

    private function getConfig(): Config
    {
        if (!isset($this->config)) {
            $this->config = new Config();
        }
        return $this->config;
    }
}
