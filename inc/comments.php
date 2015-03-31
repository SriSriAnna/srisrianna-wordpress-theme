<?php
/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://getbootstrap.com/components/#media
 */
class sprig_Walker_Comment extends Walker_Comment {
  function start_lvl(&$output, $depth = 0, $args = array()) {
    $GLOBALS['comment_depth'] = $depth + 1; ?>
    <ul <?php comment_class('media list-unstyled comment-' . get_comment_ID()); ?>>
    <?php
  }

  function end_lvl(&$output, $depth = 0, $args = array()) {
    $GLOBALS['comment_depth'] = $depth + 1;
    echo '</ul>';
  }

  function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {
    $depth++;
    $GLOBALS['comment_depth'] = $depth;
    $GLOBALS['comment'] = $comment;

    if (!empty($args['callback'])) {
      call_user_func($args['callback'], $comment, $args, $depth);
      return;
    }

    extract($args, EXTR_SKIP); ?>

  <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media comment-' . get_comment_ID()); ?>>
    <div class="row">
      <div class="small-2 columns">
        <?php echo get_avatar($comment, $size = '86'); ?>
      </div>
      <div class="small-10 columns">
          <h4><?php echo get_comment_author_link(); ?>
            <small>
              <time datetime="<?php echo get_comment_date('c'); ?>"><?php printf(__('%1$s', 'sprig'), get_comment_date(),  get_comment_time()); ?></time> at <?php comment_time('G:i A'); ?>
            </small>
          </h4>
          <?php edit_comment_link(__('(Edit)', 'sprig'), '', ''); ?>

          <?php if ($comment->comment_approved == '0') : ?>
            <div class="alert alert-info">
              <?php _e('Your comment is awaiting moderation.', 'sprig'); ?>
            </div>
          <?php endif; ?>

          <?php comment_text(); ?>
          <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
      </div>
    </div>




  <?php
  }

  function end_el(&$output, $comment, $depth = 0, $args = array()) {
    if (!empty($args['end-callback'])) {
      call_user_func($args['end-callback'], $comment, $args, $depth);
      return;
    }
    // Close ".media-body" <div> located in templates/comment.php, and then the comment's <li>
    echo "</li>\n";
  }
}

function sprig_get_avatar($avatar, $type) {
  if (!is_object($type)) { return $avatar; }

  $avatar = str_replace("class='avatar", "class='avatar media-object", $avatar);
  return $avatar;
}
add_filter('get_avatar', 'sprig_get_avatar', 10, 2);
