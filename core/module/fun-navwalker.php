<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
// 安全设置--------------------------boxmoe.com--------------------------
if (!defined('ABSPATH')) {echo'Look your sister';exit;}
//=========================================
// bootstrap 5 wp_nav_menu walker
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth * 2);
    $submenu = ($depth >= 1) ? '' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth-$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;
    $has_children = in_array('menu-item-has-children', $item->classes);
    
    $is_active = in_array('current-menu-item', $item->classes) || 
                in_array('current-page-item', $item->classes);
    
    $classes = [];
    $classes[] = 'nav-item';
    $classes[] = $has_children ? 'dropdown' : '';
    $classes[] = ($depth >= 1 && $has_children) ? 'dropdown-submenu dropend' : '';

    $indent = str_repeat("\t", $depth * 2);
    $output .= "\n$indent<li class=\"" . implode(' ', array_filter($classes)) . '">';

    $attributes  = '';
    $attributes .= $item->attr_title ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= $item->target ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= $item->xfn ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= $has_children ? ' href="#"' : ' href="' . esc_attr($item->url) . '"';

    $link_class = ($depth > 0) ? 'dropdown-item' : 'nav-link';
    $link_class .= $is_active ? ' active' : '';
    $children_attributes = ($depth == 0) ? 'role="button" data-bs-toggle="dropdown" aria-expanded="false"' : '';
    $attributes .= $has_children ? ' class="'. $link_class . ' dropdown-list-group-item dropdown-toggle" ' . $children_attributes : ' class="'. $link_class . '"';



    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . $item->title . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= $indent . "\t" . apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }

  function end_el(&$output, $item, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth * 2);
    $output .= "\n$indent</li>\n";
  }
}