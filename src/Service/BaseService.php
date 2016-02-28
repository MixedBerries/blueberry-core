<?php

namespace Blueberry\Core\Service;

use Interop\Container\ContainerInterface;

/**
 *
 */
class BaseService
{
  /**
   * @var ContainerInferFace
   */
  protected $container;

  function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __get($name)
  {
    return $this->container->get($name);
  }
}
