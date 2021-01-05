<?php

/**
 * @file
 * Contains star_entity.page.inc.
 *
 * Page callback for Star entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Star templates.
 *
 * Default template: star_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_star_entity(array &$variables) {
  // Fetch StarEntity Entity Object.
  $star_entity = $variables['elements']['#star_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
