<?php

namespace Drupal\ticmedemo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ticmedemo\Event\ContactEvent;



/**
 * Implements an example form.
 * Form and render elements
 * https://api.drupal.org/api/drupal/elements/8.3.x
 */
class ConfigForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'config_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('ticmedemo.config_form');

        $form['store_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#default_value' => $config->get('store_name'),
            '#required' => FALSE
        );

        $form['opening_time'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Opening time'),
            '#default_value' => $config->get('opening_time'),
            '#required' => FALSE
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit')
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * Récupération des variables du Formulaire
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::buildForm($form, $form_state);
        $config = $this->config('ticmedemo.config_form');

        $config->set('store_name', $form_state->getValue('store_name'))
            ->set('opening_time', $form_state->getValue('opening_time'));

        //EventSubscriber
        $dispatcher = \Drupal::service('event_dispatcher');
        $contactEvent = new ContactEvent($config);
        $event = $dispatcher->dispatch('contact_form.save', $contactEvent);

        $data = $event->getConfig()->get();
        $config->merge($data);

        $config->save();
    }

    /**
     * Validation des champs du Formulaire
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    protected function getEditableConfigNames()
    {
        return array(
            'ticmedemo.config_form'
        );
    }
}