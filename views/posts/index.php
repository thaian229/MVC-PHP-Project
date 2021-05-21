<?php
//echo '<table align="center">';
//
//echo '<tr>';
//foreach ($posts as $post) {
//    if($post) {
//        echo'
//        <td style="margin-left: 2vw; margin-right: 2vw; width: 20vw; height: 30vh; border: 1px solid black" align="center">
//            <a href="index.php?controller=posts&action=showPost&id=' . $post->id . '" style="text-decoration: none;">
//                <div>
//                    <img src="' . $post->thumbnailUrl . '" width="200" height="100">
//                    <br/>
//                    <p align="left"><strong style="color: #222222">' . $post->title . '</strong></p>
//                </div>
//            </a>
//        </td>';
//    }
//}
//echo '</tr>';
//
//echo '</table>';





echo '<table align="center">';

echo '<tr>';
for($i = 0; $i < 4; $i++) {
    if($posts[$i]) {
        echo'
        <td style="
                border: 1px solid black;
            " 
            align="center">
            <a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                <div>
                    <img src="' . $posts[$i]->thumbnailUrl . '" width="240" height="180">
                </div>
            </a>
        </td>';
    }
}
echo '</tr>';
echo '<tr>';
for($i = 0; $i < 4; $i++) {
    if($posts[$i]) {
        echo'
        <td style="
            margin-right: 200px;
            width: 15vw;
            height: 10vh;
            border: 1px solid black">
            <a href="index.php?controller=posts&action=showPost&id=' . $posts[$i]->id . '" style="text-decoration: none;">
                <div>
                    <p align="left"><strong style="color: #222222">' . $posts[$i]->title . '</strong></p>
                </div>
            </a>
        </td>';
    }
}

echo '</table>';
?>