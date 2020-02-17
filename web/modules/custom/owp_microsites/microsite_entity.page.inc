<?php

/**
 * @file
 * Contains microsite_entity.page.inc.
 *
 * Page callback for Microsite entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Microsite templates.
 *
 * Default template: microsite_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_microsite_entity(array &$variables) {
  // Fetch MicrositeEntity Entity Object.
  $microsite_entity = $variables['elements']['#microsite_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
