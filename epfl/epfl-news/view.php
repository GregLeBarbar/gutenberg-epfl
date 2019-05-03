<?php
    require_once(dirname(__FILE__) . '/utils.php');
    require_once(dirname(__FILE__) . '/templates/listing.php');
    require_once(dirname(__FILE__) . '/templates/highlighted_with_3_news.php');
    require_once(dirname(__FILE__) . '/templates/highlighted_with_1_news.php');
    require_once(dirname(__FILE__) . '/templates/card_with_1_news.php');
    require_once(dirname(__FILE__) . '/templates/card_with_2_news.php');
    require_once(dirname(__FILE__) . '/templates/card_with_3_news.php');

    function epfl_news_render($results, $template, $all_news_link) {
        
        $markup = "";
    
        switch ($template) {
            case "1":
                $markup = epfl_news_listing($results, $all_news_link);
                break;
            case "2":
                $markup = epfl_news_highlighted_with_3_news($results, $all_news_link);
                break;
            case "3":
                $markup = epfl_news_highlighted_with_1_news($results, $all_news_link);
                break;
            case "4":
                $markup = epfl_news_card_with_1_news($results, $all_news_link);
                break;
            case "5":
                $markup = epfl_news_card_with_2_news($results, $all_news_link);
                break;
            case "6":
                $markup = epfl_news_card_with_3_news($results, $all_news_link);
                break;
        }

        return $markup;
    }
?>