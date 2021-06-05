<iframe width=60% style="aspect-ratio: 16/9;" src="https://www.youtube.com/embed/AL4CSiYoMqA" frameborder="1"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
<?php
echo "Tiêu đề: $post->title";
echo "<br/>";
echo 'Nội dung: <a href="' . $post->videoUrl . '">link</a>';
?>