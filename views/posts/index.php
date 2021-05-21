<?php
echo '<table>';
//foreach ($posts as $post) {
    echo '<li>
    <a href="index.php?controller=posts&action=showPost&id=' . $posts[0]->id . '">' . $posts[0]->title . '</a>
  </li>';
//}
echo '</table>';
?>