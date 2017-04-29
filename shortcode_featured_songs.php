<?php

    function featured_songs(){
        global $wpdb;

        $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE featured=true");
        $first_song = "";
        foreach ($songs as $song) { $first_song = $song->media_url; break; }
        $first_song = str_replace("watch?v=", "embed/", $first_song);

        ?>
            <div class="row form-group" style="margin-right:0px">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" id="featured_songs_player" width="100%" height="500px" src="<?php echo $first_song ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-4 custom_scrollbar" style='max-height:500px; overflow-y: scroll;'>
                    <?php
                        foreach ($songs as $song) {
                            ?>
                                <div class="row featured_list" onclick="changeFeaturedSong('<?php echo $song->media_url ?>');" href="#">
                                    <div class="col-md-4">
                                        <img src="<?php echo getVideoThumbnail($song->media_url); ?>">
                                    </div>
                                    <div class="col-md-8 lead">
                                        <?php echo $song->name; ?>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        <?php
    }
    add_shortcode( 'codistan_featured_songs', 'featured_songs' );
?>
