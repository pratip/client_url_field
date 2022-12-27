<?php

namespace Drupal\client_url_field\Plugin\Field\FieldType;

use Drupal\Core\Form\FormStateInterface;
use Drupal\options\Plugin\Field\FieldType\ListStringItem;

/**
 * Plugin implementation of the 'client_url' field type.
 *
 * @FieldType(
 *   id = "client_url",
 *   label = @Translation("Client URL List"),
 *   description = @Translation("This field stores text values from a list of
 *     allowed 'value => label' pairs of pre-selected domain names."),
 *   category = @Translation("Text"),
 *   default_widget = "client_url_list_widget",
 *   default_formatter = "client_url_list_formatter",
 *   cardinality = \Drupal\Core\Field\FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED
 * )
 */
class ClientURLList extends ListStringItem {

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $element = parent::storageSettingsForm($form, $form_state, $has_data);
    $element['allowed_values']['#disabled'] = 'disabled';
    $element['allowed_values']['#description'] .= $this->t('This field is intentionally disabled since it only takes a specific set of values.');

    $module_handler = \Drupal::moduleHandler();
    $module_path = $module_handler->getModule('client_url_field')->getPath();
    $file_name = DRUPAL_ROOT . "/" . $module_path . "/assets/allowed_urls.txt";
    if (($handle = fopen($file_name, "r")) !== FALSE) {
      while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        $input_line = "{$line}|{$line}\n";
        $element['allowed_values']['#value'] .= $input_line;
      }
    }

    return $element;
  }

}
