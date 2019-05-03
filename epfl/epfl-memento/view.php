<?php
    require_once(dirname(__FILE__) . '/utils.php');
    require_once(dirname(__FILE__) . '/templates/slider.php');
    require_once(dirname(__FILE__) . '/templates/listing_with_the_first_highlighted_event.php');
    require_once(dirname(__FILE__) . '/templates/listing_without_the_first_highlighted_event.php');

    function epfl_memento_render($results, $template, $memento_name) {
        
        $markup = "";
    
        switch ($template) {
            case "1":
            case "2":
                $markup = epfl_memento_slider($results, $template, $memento_name);
                break;
    
            case "3":
                $markup = epfl_memento_listing_with_the_first_highlighted_event($results, $memento_name);
                break;
                
            case "4":
                $markup = epfl_memento_listing_without_the_first_highlighted_event($results, $memento_name);
                break;
        }
        return $markup;
    }
?>