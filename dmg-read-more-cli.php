<?php

if (defined('WP_CLI') && WP_CLI) {
    class Dmg_Read_More_Command extends WP_CLI_Command {
        /**
         * Search for posts containing a Gutenberg block within a date range.
         *
         * ## OPTIONS
         *
         * [--date-before=<date-before>]
         * : The date before which posts should be included in the search (YYYY-MM-DD format).
         *
         * [--date-after=<date-after>]
         * : The date after which posts should be included in the search (YYYY-MM-DD format).
         *
         * ## EXAMPLES
         *
         * wp dmg-read-more search --date-before=2023-10-14 --date-after=2023-09-29
         *
         * @when after_wp_load
         */
        public function search($args, $assoc_args) {
           
            $date_before = isset($assoc_args['date-before']) ? $assoc_args['date-before'] : date('Y-m-d');
            $date_after = isset($assoc_args['date-after']) ? $assoc_args['date-after'] : date('Y-m-d', strtotime('-30 days'));

            // WP_Query to search for posts
            $args = array(
                'post_type' => 'post',
                'date_query' => array(
                    'after' => $date_after,
                    'before' => $date_before,
                ),
                's' => 'custom-read-more-block', // Replace with your Gutenberg block keyword
            );

            $query = new WP_Query($args);

            // After WP_Query
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    WP_CLI::line("Post ID - " . get_the_ID());
                }
            } else {
                if ($date_before === date('Y-m-d', strtotime('-30 days')) && $date_after === date('Y-m-d')) {
                    WP_CLI::warning('No posts found in the last 30 days with the Gutenberg block.');
                } else {
                    WP_CLI::warning('No posts found in the specified date range with the Gutenberg block.');
                }
            }
                    }
    }

    WP_CLI::add_command('dmg-read-more', 'Dmg_Read_More_Command');
}




