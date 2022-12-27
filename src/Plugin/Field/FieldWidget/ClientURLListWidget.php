<?php

namespace Drupal\client_url_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsButtonsWidget;

/**
 * Plugin implementation of the 'client_url_list_widget' widget.
 *
 * @FieldWidget(
 *   id = "client_url_list_widget",
 *   label = @Translation("Check boxes for Client URLs"),
 *   field_types = {
 *     "client_url"
 *   },
 *   multiple_values = TRUE
 * )
 */
class ClientURLListWidget extends OptionsButtonsWidget {

}
