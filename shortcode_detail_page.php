<?php
    function detail_page(){
        if($_GET["content"] == "movie")
            displayMovie($_GET["id"]);
        else if($_GET["content"] == "song")
            displaySong($_GET["id"]);
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

                        <img src='http://c.saavncdn.com/001/S-D-Burman-The-Evergreen-Composer-2013-500x500.jpg' width='160px' height='160px' style='max-width:160px; float: left; margin: 0px 20px 0px 0px;'>
                        <h3><b><?php echo $row->name; ?></b></h3>
                        <p>Director: <?php echo $row->director; ?></p>
            		  	<p><?php echo $row->description; ?></p>

                    <?php
                        break;
                    }
                    ?>
	 	</div></div></br>
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

        <?php
    }
?>
