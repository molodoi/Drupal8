<?php
namespace Drupal\ticmedemo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class DemoController extends \Drupal\Core\Controller\ControllerBase
{

    public function description()
    {
        $build = array(
            '#type' => 'markup',
            '#markup' => t('Hello world!')
        );
        return $build;
    }

    public function requests(){
        $query = \Drupal::entityQuery('node');
        $nids = $query->execute();

        $query = \Drupal::entityQuery('user');
        $uids = $query->execute();

        $query = \Drupal::entityQuery('comment');
        $cids = $query->execute();

        $query = \Drupal::entityQuery('node')
        ->condition('type', 'services_typec')
        ->condition('uid', 1)
        ->condition('title', 'My', 'CONTAINS')
        ->condition('field_type_de_service.value', 'design');
        $filtered_nids = $query->execute();

        $markup = 'Node ids: '. implode(', ',$nids);
        $markup .= '<br/>User ids: '. implode(', ',$uids);
        $markup .= '<br />Comments ids: '. implode(', ',$cids);
        $markup .= '<br />Filtered_nids ids: '. implode(', ',$filtered_nids);

        $node = Node::load(reset($filtered_nids));
        $markup .= '<br /><br />Corps du noeud Titre: '. $node->getTitle() .' '. $node->body->value;

        $node->setTitle($node->title->value . '*');
        $node->save();
        $markup .= '<br /><br />Titre Modifié: '. $node->getTitle();

        $nodes = Node::loadMultiple($nids);
        foreach ($nodes as $n){
            //dsm($n);
            $markup .= '<br /><br />--> '. $n->getTitle() ;
        }

        $build = array(
            '#type' => 'markup',
            '#markup' => $markup
        );

        return $build;

    }

}