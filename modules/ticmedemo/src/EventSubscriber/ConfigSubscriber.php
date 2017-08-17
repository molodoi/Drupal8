<?php

namespace Drupal\ticmedemo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ConfigSubscriber implements EventSubscriberInterface{

    public static function getSubscribedEvents()
    {
        $events['contact_form.save'][] = array('onConfigSave', 0);
        return $events;
    }

    public function onConfigSave($event){
        $config = $event->getConfig();
        //dsm($config->get('store_name'));
        if(strpos($config->get('opening_time'), 'liquidation')){
            drupal_set_message('Un email concernant la liquidation a été envoyé à tous les clients.');
            $config->set('store_name', $config->get('store_name').' (en liquidation)');
        }
    }

}