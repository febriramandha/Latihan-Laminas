<?php

namespace Post;

// Add these import statements:
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\PostTable::class => function ($container) {
                    $tableGateway = $container->get(Model\PostTableGateway::class);
                    return new Model\PostTable($tableGateway);
                },
                Model\PostTableGateway::class => function ($container) {
                    $adapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Post);
                    return new tableGateway('post', $adapter, null, $resultSetPrototype);
                }
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function ($container) {
                    return new Controller\IndexController($container->get(Model\PostTable::class));
                }
            ]
        ];
    }
}
