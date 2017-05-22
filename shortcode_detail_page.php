<?php
    function detail_page(){
        if($_GET["content"] == "movie")
            displayMovie($_GET["id"]);
        else if($_GET["content"] == "song")
            displaySong($_GET["id"]);
        else if($_GET["content"] == "article")
            displayArticle($_GET["id"]);
    }
    add_shortcode( 'codistan_detail_page', 'detail_page' );

    function displaySong($id){
        global $wpdb;
        ?>

            <div class='row' style="padding:20px">
                <div class='col-sm-12'>

                <?php
                    $result = $wpdb->get_results( "SELECT * FROM codistan_songs WHERE id=". $id);
                    if(count($result) == 0){
            			echo "<p style='font-size:28px'><b>ERROR!</b></p>";
            			return;
                    }
                    foreach($result as $row){
                ?>

                        <img src='http://c.saavncdn.com/001/S-D-Burman-The-Evergreen-Composer-2013-500x500.jpg' width='160px' height='160px' style='max-width:160px; float: left; margin: 0px 20px 0px 0px;'>
                        <h3><b><?php echo $row->name; ?></b></h3>
                        <p>Language: <?php echo getLanguage($row->language); ?></br>
                        Genre: <?php echo getGenre($row->genre); ?></p>
                        </div></div></br>
                        <?php if($row->media_url != "N/A"){ ?>
                        <div class='row' style="padding:30px">
                            <div class="text-center embed-responsive embed-responsive-16by9" style="margin:20px;">
                                <iframe class="embed-responsive-item" id="video_player" src="<?php echo str_replace("watch?v=", "embed/", $row->media_url); ?>" width="80%" height="400px" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <?php } ?>

                        <?php
                            $count = $wpdb->get_var( "SELECT count(*) FROM codistan_images WHERE status=true AND (relatedTo=1 OR relatedTo=2) AND relatedTo_id=". $id);
                            if($count > 0){
                        ?>
                        <div class='row' style="padding:30px">
                            <p style='font-size:24px' class='text-center'><b>IMAGES</b></p>
                            <div class='row'>
                            <?php
                                $images = $wpdb->get_results("SELECT * FROM codistan_images WHERE status=true AND (relatedTo=1 OR relatedTo=2) AND relatedTo_id=" . $id);
                                $count = 1;
                                foreach ($images as $image) {
                                    ?>
                                        <div class='col-sm-4'>
                                            <img src='/<?php echo $image->media_url; ?>' style='padding:10px'>
                                        </div>
                                    <?php
                                    if($count++ % 3 == 0)
                                        echo "</div><div class='row'>";
                                }
                            ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php
                            $count = $wpdb->get_var( "SELECT count(*) FROM codistan_articles WHERE status=true AND (relatedTo=1 OR relatedTo=2) AND relatedTo_id=". $id);
                            if($count > 0){
                        ?>
                        <div class='row' style="padding:30px">
                            <p style='font-size:24px' class='text-center'><b>ARTICLES</b></p>
                            <div class='row'>
                            <?php
                                $articles = $wpdb->get_results("SELECT * FROM codistan_articles WHERE status=true AND (relatedTo=1 OR relatedTo=2) AND relatedTo_id=" . $id);
                                $count = 1;
                                foreach ($articles as $article) {
                                    ?>
                                        <a href="/detail?content=article&id=<?php echo $article->id; ?>" style="color:black;">
                                            <div class='col-sm-3 text-center'>
                                                <img src='/<?php echo $article->image; ?>' style='padding:10px'></br>
                                                <b><?php echo $article->name; ?></b></br>
                                                By <?php echo $article->author; ?>
                                            </div>
                                        </a>
                                    <?php
                                    if($count++ % 4 == 0)
                                        echo "</div><div class='row'>";
                                }
                            ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php
                        break;
                    }
    }

    function displayMovie($id){
        global $wpdb;
        ?>

            <div class='row' style="padding:20px">
                <div class='col-sm-12'>

                <?php
                    $result = $wpdb->get_results( "SELECT * FROM codistan_movies WHERE id=". $id);
                    if(count($result) == 0){
            			echo "<p style='font-size:28px'><b>ERROR!</b></p>";
            			return;
                    }
                    foreach($result as $row){
                ?>
                        <?php if($row->image != null && $row->image != ""){ ?>
                            <img src='<?php echo "/wp-content/uploads/codistan/" . $row->image; ?>' width='160px' height='160px' style='max-width:160px; float: left; margin: 0px 20px 0px 0px;'>
                        <?php } else { ?>
                            <img src='/wp-content/uploads/codistan/default.jpg' width='160px' height='160px' style='max-width:160px; float: left; margin: 0px 20px 0px 0px;'>
                        <?php } ?>
                        <h3><b><?php echo $row->name; ?></b></h3>
                        <p>Director: <?php echo $row->director; ?></p>
            		  	<p><?php echo $row->description; ?></p>

                    <?php
                        break;
                    }
                    ?>
	 	</div></div></br>
        <?php
            $count = $wpdb->get_var( "SELECT count(*) FROM codistan_songs WHERE status=true AND movie=". $id);
            if($count > 0){
        ?>
        <div class='row' style="padding:30px">
            <p style='font-size:24px' class='text-center'><b>SONGS</b></p>
            <div class="text-center embed-responsive embed-responsive-16by9" style="display:none; margin:20px;">
                <iframe class="embed-responsive-item" id="video_player" width="80%" height="400px" frameborder="0" allowfullscreen></iframe>
            </div>
            <table class="table table-hover table_songs">
                <?php
                    $songs = $wpdb->get_results( "SELECT * FROM codistan_songs WHERE status=true AND movie=". $id);
                    $count = 1;
                    foreach ($songs as $song) {

                        ?>
                            <tr onclick="play_song('<?php echo $song->media_url; ?>')"><td>
                                <?php echo $count++ . ". " . $song->name; ?>

                                <div style="float: right;">
                                    <img width="20px" src="<?php echo plugins_url( '/images/play_count.png' , __FILE__ ); ?>">
                                    <?php echo getVideoViews($song->media_url); ?>
                                </div>
                            </td></tr>
                        <?php
                    }
                ?>
            </table>
        </div>
        <?php } ?>

        <?php
            $count = $wpdb->get_var( "SELECT count(*) FROM codistan_images WHERE status=true AND relatedTo=4 AND relatedTo_id=". $id);
            if($count > 0){
        ?>
        <div class='row' style="padding:30px">
            <p style='font-size:24px' class='text-center'><b>IMAGES</b></p>
            <div class='row'>
            <?php
                $images = $wpdb->get_results("SELECT * FROM codistan_images WHERE status=true AND relatedTo=4 AND relatedTo_id=" . $id);
                $count = 1;
                foreach ($images as $image) {
                    ?>
                        <div class='col-sm-4'>
                            <img src='/<?php echo $image->media_url; ?>' style='padding:10px'>
                        </div>
                    <?php
                    if($count++ % 3 == 0)
                        echo "</div><div class='row'>";
                }
            ?>
            </div>
        </div>
        <?php } ?>

        <?php
            $count = $wpdb->get_var( "SELECT count(*) FROM codistan_articles WHERE status=true AND relatedTo=4 AND relatedTo_id=". $id);
            if($count > 0){
        ?>
        <div class='row' style="padding:30px">
            <p style='font-size:24px' class='text-center'><b>ARTICLES</b></p>
            <div class='row'>
            <?php
                $articles = $wpdb->get_results("SELECT * FROM codistan_articles WHERE status=true AND relatedTo=4 AND relatedTo_id=" . $id);
                $count = 1;
                foreach ($articles as $article) {
                    ?>
                        <a href="/detail?content=article&id=<?php echo $article->id; ?>" style="color:black;">
                            <div class='col-sm-3 text-center'>
                                <img src='/<?php echo $article->image; ?>' style='padding:10px'></br>
                                <b><?php echo $article->name; ?></b></br>
                                By <?php echo $article->author; ?>
                            </div>
                        </a>
                    <?php
                    if($count++ % 4 == 0)
                        echo "</div><div class='row'>";
                }
            ?>
            </div>
        </div>
        <?php } ?>

        <?php
    }

    function displayArticle($id){
        global $wpdb;
        ?>

            <div class='row' style="padding:20px">
                <div class='col-sm-12'>

                <?php
                    $result = $wpdb->get_results( "SELECT * FROM codistan_articles WHERE id=". $id);
                    if(count($result) == 0){
            			echo "<p style='font-size:28px'><b>ERROR!</b></p>";
            			return;
                    }
                    foreach($result as $row){
                ?>

                        <?php if($row->image != null && $row->image != ""){ ?>
                            <img src='<?php echo "/" . $row->image; ?>' width='160px' height='160px' style='max-width:160px; float: left; margin: 0px 20px 0px 0px;'>
                        <?php } else { ?>
                            <img src='/wp-content/uploads/codistan/default.jpg' width='160px' height='160px' style='max-width:160px; float: left; margin: 0px 20px 0px 0px;'>
                        <?php } ?>
                        <h3><b><?php echo $row->name; ?></b></h3>
                        <p>Author: <?php echo $row->author; ?></p>
            		  	<p><?php echo $row->content; ?></p>

                    <?php
                        break;
                    }
                    ?>
	 	</div></div></br>

        <?php
            $count = $wpdb->get_var( "SELECT count(*) FROM codistan_images WHERE status=true AND relatedTo=5 AND relatedTo_id=". $id);
            if($count > 0){
        ?>
        <div class='row' style="padding:30px">
            <p style='font-size:24px' class='text-center'><b>IMAGES</b></p>
            <div class='row'>
            <?php
                $images = $wpdb->get_results("SELECT * FROM codistan_images WHERE status=true AND relatedTo=5 AND relatedTo_id=" . $id);
                $count = 1;
                foreach ($images as $image) {
                    ?>
                        <div class='col-sm-4'>
                            <img src='/<?php echo $image->media_url; ?>' style='padding:10px'>
                        </div>
                    <?php
                    if($count++ % 3 == 0)
                        echo "</div><div class='row'>";
                }
            ?>
            </div>
        </div>
        <?php } ?>

        <?php
    }
?>
