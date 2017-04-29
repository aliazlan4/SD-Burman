<?php
    function songs_catalogue(){
        global $wpdb;

        ?>
            <div class="row sorter_row">
                <form class="form-inline">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sort_by_list">Sort by: </label>
                            <select class="form-group" id="sort_by_list">
                                <option value="movie">Movie</option>
                                <option value="song">Song</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="sorter_radio_option" id="sorter_radio_option1" value="alpha"> Alphabetically
                            </label>
                            <img style="max-width:25px" src="<?php echo plugins_url( '/images/sorter.png' , __FILE__ ); ?>">
                            <label class="radio-inline">
                                <input type="radio" name="sorter_radio_option" id="sorter_radio_option2" value="year"> Year
                            </label>
                            <img style="max-width:25px" src="<?php echo plugins_url( '/images/sorter.png' , __FILE__ ); ?>">
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-3">
                        <input type="text" class="form-control" id="search_song" placeholder="Search">
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Filter Results
                </div>
                <div class="col-md-10">
                    <?php print_r(getResultsForView()); ?>
                </div>
            </div>
        <?php
    }
    add_shortcode( 'codistan_songs_catalogue', 'songs_catalogue' );

    function getResultsForView(){
        global $wpdb;

        $result = array();
        $movies = $wpdb->get_results("SELECT * FROM codistan_movies");

        foreach ($movies as $movie) {
            $number_of_songs = $wpdb->get_var("SELECT COUNT(*) FROM codistan_songs WHERE movie=" . $movie->id . " AND status=true");
            if($number_of_songs > 0){
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE movie = " . $movie->id . " AND status=true");
                $all_songs = array();
                foreach ($songs as $song) {
                    array_push($all_songs, array("id"=>$song->id, "name"=>$song->name, "type"=>$song->song_type, "language"=>$song->language, "genre"=>$song->genre, "url"=>$song->media_url, "year"=>$song->year));
                }
                $new_movie = array("id"=>$movie->id, "name"=>$movie->name, "director"=>$movie->director, "year"=>$movie->year, "actors"=>$movie->actors, "songs" => $all_songs);
                array_push($result, $new_movie);
            }
        }

        $number_of_songs = $wpdb->get_var("SELECT COUNT(*) FROM codistan_songs WHERE song_type=1 AND status=true");
        if($number_of_songs > 0){
            $solo_songs = array();
            $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE song_type=1 AND status=true");

            foreach ($songs as $song) {
                
            }
        }

        return $result;
    }
?>
