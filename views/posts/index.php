<?php
echo '<table align="center">';

echo '<tr>';
for($i = 0; $i < 4; $i++) {
    if(!empty($posts[$i])) {
        echo'
        <td class="thumbnail_item" style="
                border: 1px solid black;
            " 
            align="center">
            <a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                <div class="thumbnail">
                    <img src="' . $posts[$i]->thumbnailUrl . '" width="240" height="180">
                </div>
            </a>
        </td>';
    }
}
echo '</tr>';
echo '<tr>';
for($i = 0; $i < 4; $i++) {
    if(!empty($posts[$i])) {
        echo'
        <td class="title_item" style="
            width: 15vw;
            border: 1px solid black">
            <a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                <div class="title">
                    <p align="left"><strong style="color: #222222">' . $posts[$i]->title . '</strong></p>
                </div>
            </a>
        </td>';
    }
}
echo '</table>';
echo '<br/><br/>';
echo '<table align="center">';
echo '<tr>';
for($i = 4; $i < 8; $i++) {
    if(!empty($posts[$i])) {
        echo'
        <td class="thumbnail_item" style="
                border: 1px solid black;
            " 
            align="center">
            <a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                <div class="thumbnail">
                    <img src="' . $posts[$i]->thumbnailUrl . '" width="240" height="180">
                </div>
            </a>
        </td>';
    }
    else continue;
}
echo '</tr>';
echo '<tr>';
for($i = 4; $i < 8; $i++) {
    if(!empty($posts[$i])) {
        echo'
        <td class="title_item" style="
            width: 15vw;
            border: 1px solid black">
            <a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                <div class="title">
                    <p align="left"><strong style="color: #222222">' . $posts[$i]->title . '</strong></p>
                </div>
            </a>
        </td>';
    }
}

echo '</table>';
?>