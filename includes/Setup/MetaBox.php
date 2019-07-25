<?php
/**
 * Created by PhpStorm.
 * User: iman
 * Date: 24/07/2019
 * Time: 07:44 PM
 */

namespace Setup;


class MetaBox
{

    function __construct()
    {
        add_action('add_meta_boxes', [$this, 'main_meta_box']);
        add_action('save_post', [$this, 'main_metabox_inputs_save_func']);
    }

    function main_meta_box()
    {

        add_meta_box('mb_main_meta_box', 'Redirect Info', [
            $this,
            'main_metabox_callback',
        ], 'links');

    }

    function main_metabox_callback($post)
    {
        $main_link = get_post_meta($post->ID, "main_link", TRUE);
        $redirect_link = get_post_meta($post->ID, "redirect_link", TRUE);
        $used_number = get_post_meta($post->ID, "used_short_link", TRUE);
        ?>

        <table class="form-table">
            <tbody>

            <tr class="user-first-name-wrap">
                <th><label for="main_link">Main Link</label></th>
                <td><input type="text" name="main_link" id="main_link"
                           value="<?= esc_url($main_link) ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="user-first-name-wrap">
                <th><label for="redirect_link">Short Link</label></th>
                <td><input type="text" name="redirect_link" id="redirect_link"
                           value="<?php if (!empty($redirect_link)) {
                               echo $redirect_link;
                           } else {
                               echo "Your short link was created after save post";
                           } ?>" class="regular-text" readonly>
                </td>
            </tr>
            <tr class="user-first-name-wrap">
                <th><label for="redirect_link">Used Number</label></th>
                <td><?= !empty($used_number) ? $used_number : 0; ?>
                </td>
            </tr>

            </tbody>
        </table>
        <?PHP
    }


    /**
     * @param $post_id
     * save Meta Boxes
     */

    function main_metabox_inputs_save_func($post_id)
    {
        if (array_key_exists('main_link', $_POST)) {
            if (!empty($_POST['main_link'])) {
                update_post_meta(
                    $post_id,
                    'main_link',
                    esc_url($_POST['main_link'])
                );


                $result = update_post_meta(
                    $post_id,
                    'redirect_link',
                    site_url() . '/' . $this->getRandomCode(3) . $post_id
                );
                if ($result) {
                    update_post_meta($post_id, "used_short_link", 0);
                }
            }
        }

    }

    function getRandomCode($digits)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

}
