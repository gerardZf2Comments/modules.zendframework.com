<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZfModule;

use Zend\Mvc\ModuleRouteListener;
use Zend\Cache\StorageFactory;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'zfmodule_mapper_module' => function ($sm) {
                    $mapper = new Mapper\Module();
                    $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                    $mapper->setEntityPrototype(new Entity\Module);
                    $mapper->setHydrator(new Mapper\ModuleHydrator());
                    return $mapper;
                },
                'zfmodule_service_module' => 'ZfModule\Service\ModuleFactory',
            )
        );
    }
}
