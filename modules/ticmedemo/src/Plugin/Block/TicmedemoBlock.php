<?php
namespace Drupal\ticmedemo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Message
 *
 * @Block(
 *   id = "ticmedemo_helloblock",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class TicmedemoBlock extends BlockBase{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return array(
            '#markup' => $this->t('Hello, '. $this->configuration['ticmedemo_helloblock_name']),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        $form['ticmedemo_helloblock_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Firstname'),
            '#description' => $this->t('Who do you want to say hello to?'),
            '#default_value' => isset($config['ticmedemo_helloblock_name']) ? $config['ticmedemo_helloblock_name'] : '',
        );

        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['ticmedemo_helloblock_name'] = $values['ticmedemo_helloblock_name'];
    }

    public function defaultConfiguration(){
        return array(
            'ticmedemo_helloblock_name' => 'test block'
        );
    }


}