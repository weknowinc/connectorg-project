<?php

/**
 * @file
 * Contains tool_entity.page.inc.
 *
 * Page callback for Tool entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Tool templates.
 *
 * Default template: tool_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_tool_entity(array &$variables) {
  // Fetch ToolEntity Entity Object.
  $tool_entity = $variables['elements']['#tool_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
