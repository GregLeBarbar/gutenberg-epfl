<?php
    require_once(dirname(__FILE__).'/utils.php');

    function epfl_news_render($results, $template, $all_news_link) {

        $markup = "";

        if ("1" == $template) {
            $markup .= '<div class="container my-3">';
        } elseif ("4" == $template || "5" == $template || "6" == $template) {
            $markup .= '<div class="container-full my-3 pl-5">';
        } else {
            $markup .= '<div class="container-full my-3">';
        }
        $markup .= '<div class="list-group">';

        foreach($results as $news) {

            $is_first_event    = ($count==1);
            $image_description = epfl_news_get_image_description($news);
            $category          = epfl_news_get_label_category($news);
            $publish_date      = epfl_news_get_publish_date($news);
            $subtitle          = epfl_news_get_subtitle($news);
            $visual_url        = epfl_news_get_visual_url($news);
            $video_name        = "teaser_" . str_replace("https://actu.epfl.ch/news/", "", $news->news_url);
            $media_url         = get_attachment_url_by_slug($video_name);
            
            if (2 == $template and 1 != $count and false == $header) {

                $header = true;
                $markup .= '<div class="container pb-5 offset-xl-top pt-5 pt-xl-0">';
                $markup .= '<div class="row">';
                $markup .= '<div class="col-lg-10 offset-lg-1">';
                $markup .= '<div class="row mb-4">';
            }

            if (("5" == $template  or "6" == $template or "4" == $template) and $is_first_event) {
                $markup .= '<h2 class="mt-5 mb-4">';
                esc_html_e('The latest news', 'epfl');
                $markup .= '</h2>';
                $markup .= '<div class="row">';
            }
    
            if ("1" == $template){ // TEMPLATE LISTING

                $markup .= '<a href="' . esc_url($news->news_url) . '" class="list-group-item list-group-teaser link-trapeze-vertical">';
                $markup .= '<div class="list-group-teaser-container">';
                $markup .= '<div class="list-group-teaser-thumbnail">';
                $markup .= '<picture>';
                $markup .= '<img src="' . esc_url($visual_url) . '" class="img-fluid" alt="' . esc_attr($image_description) . '">';
                $markup .= '</picture>';
                $markup .= '</div>';
                $markup .= '<div class="list-group-teaser-content">';
                $markup .= '<p class="h5">' . esc_html($news->title) . '</p>';
                $markup .= '<p>';
                $markup .= '<time datetime="' . esc_attr($publish_date) . '"><span class="sr-only">Published:</span>' . esc_html($publish_date) . '</time>';
                $markup .= '<span class="text-muted"> — ' . esc_html($subtitle) . '</span>';
                $markup .= '</p>';
                $markup .= '</div>';
                $markup .= '</div>';
                $markup .= '</a>';
            }
            $count++;
        } // end foreach

        if ("true" == $display_all_news_link and 2 != $template and 4 != $template and "" != $url_channel) {
            $markup .= '<p class="text-center">';
            $markup .= '<a class="link-pretty" href="' . $url_channel . '">' . esc_html_e("All news", "epfl" ) . '</a>';
            $markup .= '</p>';
        }

        $markup .= '</div>';
        $markup .= '</div>';

        return $markup;
    }
?>