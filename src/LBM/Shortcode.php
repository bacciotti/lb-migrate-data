<?php

namespace LBM;

class Shortcode
{
    protected $settings_page_properties;

    public function __construct($settings_page_properties)
    {
        $this->settings_page_properties = $settings_page_properties;
        $this->run();
    }

    public function run()
    {
        add_shortcode('lbm_shortcode', array($this, 'lbm_shortcode'));
    }

    function lbm_shortcode()
    {
        return $this->teste();
    }

    function teste()
    {
        require_once(ABSPATH . 'wp-config.php');
        require_once(ABSPATH . 'wp-includes/wp-db.php');
        require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');

        $file = plugin_dir_path(__FILE__) . "data.txt";
        $contents = file_get_contents($file);
        $lines = explode("\n", $contents);

        $arr_examples_1 = [
            'EXAMPLE 1',
            'EXAMPLE 2',
            'EXAMPLE 3',
            'EXAMPLE 4'
        ];

        $arr_examples_2 = [
			'EXAMPLE 1',
			'EXAMPLE 2',
			'EXAMPLE 3',
			'EXAMPLE 4',
			'EXAMPLE 5',
			'EXAMPLE 6',
			'EXAMPLE 7',
			'EXAMPLE 8',
			'EXAMPLE 9'
			];


        $cidade = null;
        $esp = null;
        $texto = null;
        $title = null;
        $count = 0;

        foreach ($lines as $item) {
            if (trim($item) == '-----------------------------------------------------------------') {

                $cidade_id = get_cat_ID(trim($cidade));
                if ($cidade_id == 0) {
                    $cidade_id = wp_create_category($cidade);
                }

                $esp_id = get_cat_ID(trim($esp));
                if ($esp_id == 0) {
                    $esp_id = wp_create_category($esp);
                }

                $new_post = array(
                    'post_title' => $title,
                    'post_content' => $texto,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_category' => array($cidade_id, $esp_id)
                );
                wp_insert_post($new_post);

                $texto = null;
                $count = 0;
            } else {
                if (in_array(trim($item), $arr_cidades)) {
                    $cidade = $item;
                } elseif (in_array(trim($item), $arr_esp)) {
                    $esp = $item;
                } else {
                    if ($count == 0) {
                        $title = $item;
                        $count = 1;
                    }
                    $texto .= $item . "<br>";
                }
            }
        }
        return 'Done!';
    }
}
