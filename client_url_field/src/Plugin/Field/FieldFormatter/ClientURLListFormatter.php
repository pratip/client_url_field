<?php

namespace Drupal\client_url_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'client_url_list_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "client_url_list_formatter",
 *   label = @Translation("Field formatter for Client URLs"),
 *   field_types = {
 *     "client_url"
 *   }
 * )
 */
class ClientURLListFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $domains = [];

    foreach ($items as $item) {
      $url = $item->value;
      if (!preg_match('#^http(s)?://#', $url)) {
        $url = 'http://' . $url;
      }
      $domain = preg_replace('/^www\./', '', parse_url($url, PHP_URL_HOST));

      // @todo Device a more elegant solution to display the base domain
      // ignoring the subdomains in the URL. Maybe a TLD lookup is necessary
      // after all. This only covers 3 domain extensions.
      $domain_parts = explode('.', $domain);
      $base_domain_parts = array_slice($domain_parts, -3);
      if (!in_array($base_domain_parts[1], ['com', 'co', 'net'])) {
        array_shift($base_domain_parts);
      }
      $base_domain_parts_url = $restructured_url = implode('.', $base_domain_parts);
      if (!preg_match('#^http(s)?://#', $base_domain_parts_url)) {
        $restructured_url = 'http://' . $restructured_url;
      }
      $domains[$restructured_url] = $base_domain_parts_url;
    }

    foreach ($domains as $url => $text) {
      $element[] = [
        '#type' => 'link',
        '#title' => $text,
        '#url' => Url::fromUri($url),
      ];
    }

    return $element;
  }

}
