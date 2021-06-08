<div>
    <div><button onclick="changeBar();"><<</button></div>
    <div name="categories-tab">
        <a href="index.php?controller=posts&action=categoryList" style="text-decoration: none;"><span>All Category</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=automobile&page=1" style="text-decoration: none;"><span>Automobile</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=culture&page=1" style="text-decoration: none;"><span>Culture</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=education&page=1" style="text-decoration: none;"><span>Education</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=food&page=1" style="text-decoration: none;"><span>Food</span></a>
    </div>
    <div name="categories-tab" style="display: none;">
        <a href="index.php?controller=posts&action=getCategory&category=game&page=1" style="text-decoration: none;"><span>Game</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=movie&page=1" style="text-decoration: none;"><span>Movie</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=music&page=1" style="text-decoration: none;"><span>Music</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=sport&page=1" style="text-decoration: none;"><span>Sport</span></a>
        <a href="index.php?controller=posts&action=getCategory&category=technology&page=1" style="text-decoration: none;"><span>Technology</span></a>
    </div>
    <div id="categories-bar">
    </div>
    <div><button onclick="changeBar();">>></button></div>
</div>
<script>
    changeBar = () => {
        var tabs = document.getElementsByName("categories-tab")
        console.log(tabs)
        for (var i = 0; i < tabs.length; i++) {
            if (tabs[i].hasAttribute("style")) {
                tabs[i].removeAttribute('style');
            }
            else
                tabs[i].setAttribute('style', "display: none;")
        }
    }
</script>