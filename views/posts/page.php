<script>
    var currentUrl = window.location.href
    var currentPageId = currentUrl.split("&page=")[1]
    function nextPage() {
        var nextPageId = parseInt(currentPageId) - 1
        window.location.href = currentUrl.split("&page=")[0] + "&page=" + nextPageId.toString()
    };
    function previousPage() {
        var previousPageId = parseInt(currentPageId) + 1
        window.location.href = currentUrl.split("&page=")[0] + "&page=" + previousPageId.toString()
    };
</script>
<div align="center">
    <br/><br/>
    <table>
        <tr>
            <?php
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
            ?>
        </tr>
        <tr>
            <?php
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
            ?>
    </table>
    <br/><br/>
    <table align="center">
        <tr>
            <?php
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
            ?>
        </tr>
        <tr>
            <?php
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
            ?>
    </table>
    <br/><br/><br/><br/>
    <div>
        <?php
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $pageId = explode("&page=",$url)[1];
            if ($pageId != 1)
                echo '<button class="button button1" onclick="nextPage();">Next Page</button>';
            echo 'Page ' . $pageId;
            if (count($posts) == 8)
                echo '<button class="button button2" onclick="previousPage();">Previous Page</button>';
        ?>
    </div>
    <br/><br/><br/><br/>
</div>
