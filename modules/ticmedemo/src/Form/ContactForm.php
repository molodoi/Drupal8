<?php

namespace Drupal\ticmedemo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Implements an example form.
 * Form and render elements
 * https://api.drupal.org/api/drupal/elements/8.3.x
 */
class ContactForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'contact_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['contact_title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#maxlength' => 255,
            '#default_value' => '',
            '#required' => FALSE
        );

        $form['contact_email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#default_value' => '',
            '#required' => TRUE
        );

        $form['contact_message'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Your message'),
            '#description' => $this->t('Please add "Drupal" in this message'),
            '#default_value' => '',
            '#required' => TRUE
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit')
        );

        return $form;
    }

    /**
     * Récupération des variables du Formulaire
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $form_state->getValue('contact_email');
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
        }
    }

    /**
     * Validation des champs du Formulaire
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (strlen($form_state->getValue('contact_email')) < 3) {
            $form_state->setErrorByName('contact_email', $this->t('The email is too short. Please enter a full email.'));
        }
    }
}