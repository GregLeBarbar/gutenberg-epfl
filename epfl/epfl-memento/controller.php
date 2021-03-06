<?php

/**
 * Plugin Name: EPFL Memento shortcode
 * Description: provides a shortcode to display events feed
 * @version: 1.0
 * @copyright: Copyright (c) 2017 Ecole Polytechnique Federale de Lausanne, Switzerland
 *
 * Text Domain: epfl-memento
 * Domain Path: /languages
 */

define("MEMENTO_API_URL", "https://memento.epfl.ch/api/v1/mementos/");
define("MEMENTO_API_URL_IFRAME", "https://memento.epfl.ch/webservice/?frame=1");
require_once(dirname(__FILE__).'/../utils.php');
require_once(dirname(__FILE__).'/view.php');

/**
 * Returns the number of events according to the template
 *
 * @param $template: id of template
 * @return the number of events
 */
function epfl_memento_get_limit($template)
{
    switch ($template){
        case "1":
        case "2":
            $limit = 10;
            break;
        case "3":
        case "4":
            $limit = 5;
            break;
        default:
            $limit = 10;
    }
    return $limit;
}

/**
 * Build api URL of events
 *
 * @param $memento: slug of memento
 * @param $template: id of the template
 * @param $lang: lang of the event (fr or en)
 * @param $category: id of the event category
 * @param $keyword: keyword to filter events
 * @param $period: period to filter past event or upcoming events
 * @return the API URL of the memento
 */
function epfl_memento_build_api_url($memento, $lang, $template, $category, $keyword, $period)
{
    // returns the number of events according to the template
    $limit = epfl_memento_get_limit($template);

    // call REST API to get the number of mementos
    $memento_response = Utils::get_items(MEMENTO_API_URL);

    // build URL with all mementos
    $url = MEMENTO_API_URL . '?limit=' . $memento_response->count;
    $mementos = Utils::get_items($url);

    // FIXME: we must improve REST API MEMENTO to be able to filter by memento_slug
    $memento_id = $memento;
    /*
    if(property_exists($mementos, 'results'))
    {
        foreach($mementos->results as $current_memento) {
            if ($current_memento->slug === $memento) {
                $memento_id = $current_memento->id;
                break;
            }
        }
    }*/

    // return events in FR if events exist in this language.
    // otherwise return events in EN (if events exist in this language).
    if ('fr' === $lang) {
        $lang = 'fr,en';
    } else {
        $lang = 'en,fr';
    }

    // define API URL
    $url = MEMENTO_API_URL . $memento_id . '/events/?format=json&lang=' . $lang . '&limit=' . $limit;

    // filter by category
    if ($category !== '') {
        $url .= '&category=' . $category;
    }

    // keyword
    if ($keyword !== '') {
        $url .= '&keywords=' . $keyword;
    }

    // period
    if ($period === 'past' or $period === 'upcoming') {
        $url .= '&period=' . $period;
    }

    return $url;
}

/**
 * Check the required parameters
 *
 * @param $memento: slug of memento
 * @param $lang: lang of event
 */
function epfl_memento_check_required_parameters($memento, $lang)
{

    // check lang
    if ($lang !==  "fr" && $lang !== "en" ) {
        return FALSE;
    }

    // check memento
    if ($memento === "") {
        return FALSE;
    }

    return TRUE;
}

/**
 * Main function of shortcode
 */
function greglebarbar_memento_render( $attributes ) {

    // sanitize parameters
    $memento  = sanitize_text_field( $attributes['memento'] ) ?: '1';
    $lang     = sanitize_text_field( $attributes['lang'] ) ?: 'en';
    $template = sanitize_text_field( $attributes['template'] ) ?: '1';
    $category = sanitize_text_field( $attributes['category'] );
    $keyword  = sanitize_text_field( $attributes['keyword'] );
    $period   = sanitize_text_field( $attributes['period'] );

    /*
    var_dump("Memento: " . $memento);
    var_dump("Lang: " . $lang);
    var_dump("Template: " . $template);
    */

    if (epfl_memento_check_required_parameters($memento, $lang) == FALSE) {
        return Utils::render_user_msg("Memento shortcode: Please check required parameters");
    }

    $url = epfl_memento_build_api_url(
        $memento,
        $lang,
        $template,
        $category,
        $keyword,
        $period
    );
    $events = Utils::get_items($url);
    
    // $memento => memento_name
    $markup = epfl_memento_render($events->results, $template, $memento);
    return $markup;
}

?>