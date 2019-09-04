<?php
namespace Drupal\xstats;

use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;

class XstatsServiceProvider extends ServiceProviderBase implements ServiceProviderInterface {

    public function alter(ContainerBuilder $container)
    {
         $definition = $container->getDefinition('statistics.storage.node');
         $definition->setClass('Drupal\xstats\XstatsDatabaseStorage\XstatsDatabaseStorage');
    }
}
