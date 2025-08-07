<?php

function mytheme_enqueue_scripts() {
  wp_enqueue_script(
    'mytheme-theme-js',
    get_template_directory_uri() . '/assets/js/theme.js',
    array(),
    filemtime(get_template_directory() . '/assets/js/theme.js'),
    true
  );

  wp_enqueue_style(
    'mytheme-photo-css',
    get_template_directory_uri() . '/assets/css/photo.css',
    array(),
    filemtime(get_template_directory() . '/assets/css/photo.css')
  );

  wp_enqueue_style(
    'mytheme-animate-css',
    get_template_directory_uri() . '/assets/css/animate.css',
    array(),
    filemtime(get_template_directory() . '/assets/css/animate.css')
  );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');

function traveltools_enqueue_styles() {
  wp_enqueue_style(
    'traveltools-style',
    get_template_directory_uri() . '/dist/style.css',
    array(),
    filemtime(get_template_directory() . '/dist/style.css')
  );
}
add_action('wp_enqueue_scripts', 'traveltools_enqueue_styles');

function traveltools_register_menus() {
  register_nav_menus([
    'primary' => __('Primary Menu', 'traveltools'),
    'footer' => __('Footer Menu', 'traveltools'),
  ]);
}
add_action('after_setup_theme', 'traveltools_register_menus');

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'    => 'Theme Options',
    'menu_title'    => 'Theme Options',
    'menu_slug'     => 'theme-options',
    'capability'    => 'edit_posts',
    'redirect'      => false
  ));
}

function add_tinymce_color_buttons($buttons) {
  array_push($buttons, 'forecolor', 'backcolor');
  return $buttons;
}
add_filter('mce_buttons_2', 'add_tinymce_color_buttons');

//----------------------------------------------------------------------------------
// --------- FEED PARSING & REST API ----------------------------------------------
//----------------------------------------------------------------------------------

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/resources', [
        'methods' => 'GET',
        'callback' => 'custom_get_rss_resources',
        'permission_callback' => '__return_true',
    ]);
});

function get_tags_for_item($title, $desc, $tag_rules) {
    $tags = [];
    $text = strtolower($title . ' ' . $desc);
    foreach ($tag_rules as $tag => $keywords) {
        foreach ($keywords as $keyword) {
            if (strpos($text, strtolower($keyword)) !== false) {
                $tags[] = $tag;
                break;
            }
        }
    }
    return array_unique($tags);
}

function custom_get_rss_resources(WP_REST_Request $request) {
    include_once(ABSPATH . WPINC . '/feed.php');

    $page = max(1, intval($request->get_param('page') ?? 1));
    $per_page = max(1, min(50, intval($request->get_param('per_page') ?? 20)));

    $feed_urls = [
        // Mindfulness & Meditation
        'https://www.mindful.org/feed/',
        'https://www.psychologytoday.com/us/topics/mindfulness/feed',
        'https://www.lionsroar.com/feed/',
        'https://www.tenpercent.com/feed/',

        // Mental Health & Anxiety
        'https://www.psychologytoday.com/us/topics/anxiety/feed',
        'https://www.nimh.nih.gov/health/publications/rss.xml',
        'https://www.mentalhealth.gov/feed',

        // Nutrition & Healthy Eating
        'https://www.health.harvard.edu/blog/feed',
        'https://www.nutrition.org.uk/feed',
        'https://nutritionfacts.org/feed/',

        // Fitness & Movement
        'https://www.acefitness.org/education-and-resources/professional/expert-articles/rss/',
        'https://www.runnersworld.com/rss/all.xml',
        'https://www.menshealth.com/rss/all.xml',
        'https://www.womenshealthmag.com/rss/all.xml',

        // Sleep & Rest
        'https://sleepfoundation.org/feed',
        'https://www.sleep.org/feed',

        // General Wellness & Lifestyle
        'https://www.wellandgood.com/feed/',
        'https://www.gaiam.com/rss/all.xml',
    ];

    $tag_rules = [
        'Mindfulness' => ['mindful', 'meditation', 'awareness', 'breath', 'present'],
        'Nutrition'   => ['nutrition', 'diet', 'food', 'healthy eating', 'vitamin'],
        'Fitness'     => ['exercise', 'fitness', 'workout', 'training', 'movement'],
        'Anxiety'     => ['anxiety', 'stress', 'worry', 'panic'],
        'Sleep'       => ['sleep', 'insomnia', 'rest', 'nap'],
    ];

    $items = [];

    $cutoff = strtotime('-2 years');

    foreach ($feed_urls as $feed_url) {
        $rss = fetch_feed($feed_url);
        if (!is_wp_error($rss)) {
            $maxitems = $rss->get_item_quantity(50);
            $rss_items = $rss->get_items(0, $maxitems);

            foreach ($rss_items as $item) {
                $item_date = strtotime($item->get_date('c'));
                if ($item_date < $cutoff) {
                    continue; // skip old
                }

                $title = $item->get_title();
                $link = $item->get_permalink();
                $desc = $item->get_description();
                $date = $item->get_date('c');

                $excerpt = wp_trim_words(strip_tags($desc), 25, '...');

                $tags = get_tags_for_item($title, $desc, $tag_rules);

                $image = null;
                $enclosure = $item->get_enclosure();
                if ($enclosure) {
                    $image = $enclosure->get_link();
                } else {
                    if (preg_match('/<img.*?src=["\'](.*?)["\']/', $desc, $matches)) {
                        $image = $matches[1];
                    }
                }

                $items[] = [
                    'title' => $title,
                    'link' => $link,
                    'excerpt' => $excerpt,
                    'pubDate' => $date,
                    'tags' => $tags,
                    'image' => $image,
                ];
            }
        }
    }

    // Sort newest first
    usort($items, fn($a, $b) => strtotime($b['pubDate']) - strtotime($a['pubDate']));

    $total_items = count($items);
    $total_pages = ceil($total_items / $per_page);
    $paged_items = array_slice($items, ($page - 1) * $per_page, $per_page);

    return rest_ensure_response([
        'items' => $paged_items,
        'pagination' => [
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page,
        ],
    ]);
}