<?php
/*
Plugin Name: Network Site Stats
Description: Thống kê các site trong Multisite
Author: PP
Network: true
*/

if (!defined('ABSPATH')) exit;

// Tạo menu trong Network Admin
add_action('network_admin_menu', function () {
    add_menu_page(
        'Network Site Stats',
        'Site Stats',
        'manage_network',
        'network-site-stats',
        'nss_render_page'
    );
});

// Render page
function nss_render_page() {
    ?>
    <div class="wrap">
        <h1>Network Site Stats</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Site Name</th>
                <th>Post Count</th>
                <th>Latest Post</th>
            </tr>
    <?php

    $sites = get_sites();

    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        $name = get_bloginfo('name');

        $post_count = wp_count_posts()->publish;

        $latest_post = get_posts([
            'numberposts' => 1
        ]);

        $latest_date = $latest_post ? $latest_post[0]->post_date : 'No posts';

        echo "<tr>
            <td>{$site->blog_id}</td>
            <td>{$name}</td>
            <td>{$post_count}</td>
            <td>{$latest_date}</td>
        </tr>";

        restore_current_blog();
    }

    ?>
        </table>
    </div>
    <?php
}