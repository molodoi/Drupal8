<?php
namespace Drupal\ticmedemo\Event;

use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Config\Config;

class ContactEvent extends Event {

    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }



}