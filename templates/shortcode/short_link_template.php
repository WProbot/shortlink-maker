<style>
  .links_body{
    width: 100%;
    float: right;
  }
  .link_box{
    margin: 20px 0;
    border-bottom: 1px solid #ccc;
  }
  .link_box_item{
    width: 50%;
    float: left;
  }
  .link_box_item .left{
    width: 50%;
    float: left;
    font-weight: bold;
    text-align: left;
    direction: ltr;
  }
  .link_box_item .right{
    width: 50%;
    float: right;
    text-align: left;
    direction: ltr;
  }
</style>
<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = new WP_Query( array( 'post_type' => 'links' ,'posts_per_page' => 10,'paged' => $paged) );
if($query->have_posts()):
while ($query->have_posts()):
  $query->the_post();
?>
<div class="links_body">
  <div class="link_box">
    <div class="link_box_item">
      <div class="left">
        Title =
      </div>
      <div class="right">
        <?=the_title()?>
      </div>

    </div>
    <div class="link_box_item">
      <div class="left">Main Link =</div>
      <div class="right"><?=get_post_meta(get_the_ID(),"main_link",TRUE)?></div>
    </div>
    <div class="link_box_item">
      <div class="left">Short Link = </div><div class="right"><?=get_post_meta(get_the_ID(),"redirect_link",TRUE)?></div>
    </div>
    <div class="link_box_item">
      <div class="left">
        Used Short link number=
      </div>

      <div class="right">
        <?php
        $used_short_link = get_post_meta(get_the_ID(),"used_short_link",TRUE);
        echo !empty($used_short_link) ? $used_short_link : 0;
        ?>
      </div>
    </div>
  </div>
</div>

<?PHP
endwhile;
?>
  <div class="pagination">
    <?php

    echo paginate_links( array(
      'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
      'total'        => $query->max_num_pages,
      'current'      => max( 1, get_query_var( 'paged' ) ),
      'format'       => '?paged=%#%',
      'show_all'     => false,
      'type'         => 'plain',
      'end_size'     => 2,
      'mid_size'     => 1,
      'prev_next'    => true,
      'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
      'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
      'add_args'     => true,
      'add_fragment' => '',
    ) );
    ?>
  </div>
<?PHP
endif;
