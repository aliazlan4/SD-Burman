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
                                <option value="song" <?php if($_SESSION["sort_by"] == "song") echo "selected"; ?>>Song</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                            <label class="radio-inline" onclick="change_sorting('alpha', '<?php echo $_GET["sorting_order"]; ?>')">
                                <input type="radio" name="sorter_radio_option" id="sorter_radio_option1" value="alpha" <?php if(!isset($_GET["sorting"])) echo "checked"; ?>> Alphabetically
                            </label>
                            <img style="max-width:25px" src="<?php echo plugins_url( '/images/sorter.png' , __FILE__ ); ?>"  onclick="change_sorting('alpha', '<?php if($_GET["sorting_order"] != "desc") echo "desc"; ?>')">
                            <label class="radio-inline" onclick="change_sorting('year', '<?php echo $_GET["sorting_order"]; ?>')">
                                <input type="radio" name="sorter_radio_option" id="sorter_radio_option2" value="year" <?php if(isset($_GET["sorting"])) echo "checked"; ?>> Year
                            </label>
                            <img style="max-width:25px" src="<?php echo plugins_url( '/images/sorter.png' , __FILE__ ); ?>"   onclick="change_sorting('year', '<?php if($_GET["sorting_order"] != "desc") echo "desc"; ?>')">
                        </div>
                    </div>
                </form>
                <div class="col-md-3 col-md-offset-3">
                    <input type="text" class="form-control" id="search_song" placeholder="Search">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?php showFilters(); ?>
                </div>
                <div class="col-md-10">
                    <?php
                        if($_SESSION["sort_by"] == "movie")
                            viewByMovies();
                        else if($_SESSION["sort_by"] == "song")
                            viewBySongs();
                    ?>
                </div>
            </div>
        <?php
    }
    add_shortcode( 'codistan_songs_catalogue', 'songs_catalogue' );

    function viewByMovies(){
        $data = getResultsForView_Movies();
        foreach ($data as $movie) {
            ?>
                <div class="row catalogue_colomn">
                    <div class="text-center embed-responsive embed-responsive-16by9" style="display:none; margin:20px;">
                        <iframe class="embed-responsive-item" id="player_<?php echo $movie["id"]; ?>" width="80%" height="400px" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-2">
                        <?php if($movie["image"] != null && $movie["image"] != ""){ ?>
                            <img width="125px" height="150px" src="<?php echo "/wp-content/uploads/codistan/" . $movie["image"]; ?>">
                        <?php } else { ?>
                            <img width="125px" height="150px" src="http://c.saavncdn.com/001/S-D-Burman-The-Evergreen-Composer-2013-500x500.jpg">
                        <?php } ?>
                    </div>
                    <div class="col-md-10">
                        <h5><a href="/detail/?content=movie&id=<?php echo $movie["id"]; ?>" style="color:black"><?php echo $movie["name"]; ?></a></h5>
                        <table class="song_detail_table" id="song_detail_table_<?php echo $movie["id"]; ?>">
                            <tr>
                                <td>Language</td><td> : </td><td id="song_detail_language_<?php echo $movie["id"] ?>">Urdu/Bengali</td>
                            </tr>
                            <tr>
                                <td>Genre</td><td> : </td><td id="song_detail_genre_<?php echo $movie["id"] ?>">Motherhood</td>
                            </tr>
                            <tr>
                                <td>Year</td><td> : </td><td id="song_detail_year_<?php echo $movie["id"] ?>">1990</td>
                            </tr>
                        </table></br>
                        <table class="table table-hover table_songs">
                            <?php
                                $count = 1;
                                foreach ($movie["songs"] as $song) {

                                    ?>
                                        <tr onclick="catalogue_play_song(<?php echo $movie["id"]; ?>, '<?php echo $song["url"]; ?>', '<?php echo getLanguage($song["language"]); ?>', '<?php echo getGenre($song["genre"]); ?>', '<?php echo $song["year"] ?>')"><td>
                                            <?php echo $count++ . ". " . $song["name"]; ?>

                                            <div style="float: right;">
                                                <img width="20px" src="<?php echo plugins_url( '/images/play_count.png' , __FILE__ ); ?>">
                                                <?php echo getVideoViews($song["url"]); ?>
                                            </div>
                                        </td></tr>
                                    <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
            <?php
        }
    }

    function getResultsForView_Movies(){
        global $wpdb;

        $result = array();
        $movie;
        if(isset($_GET["sorting"]) && $_GET["sorting"] == "year"){
            if(isset($_GET["sorting_order"]) && $_GET["sorting_order"] == "desc")
                $movies = $wpdb->get_results("SELECT * FROM codistan_movies ORDER BY year DESC");
            else
                $movies = $wpdb->get_results("SELECT * FROM codistan_movies ORDER BY year");
        }
        else{
            if(isset($_GET["sorting_order"]) && $_GET["sorting_order"] == "desc")
                $movies = $wpdb->get_results("SELECT * FROM codistan_movies ORDER BY name DESC");
            else
                $movies = $wpdb->get_results("SELECT * FROM codistan_movies ORDER BY name");
        }

        foreach ($movies as $movie) {
            $number_of_songs = $wpdb->get_var("SELECT COUNT(*) FROM codistan_songs WHERE movie=" . $movie->id . " AND status=true" . getFilterQuery());
            if($number_of_songs > 0){
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE movie = " . $movie->id . " AND status=true" . getFilterQuery());
                $all_songs = array();
                foreach ($songs as $song) {
                    array_push($all_songs, array("id"=>$song->id, "name"=>$song->name, "type"=>$song->song_type, "language"=>$song->language, "genre"=>$song->genre, "url"=>$song->media_url, "year"=>$song->year));
                }
                $new_movie = array("id"=>$movie->id, "name"=>$movie->name, "image"=>$movie->image,"director"=>$movie->director, "year"=>$movie->year, "actors"=>$movie->actors, "songs"=>$all_songs);
                array_push($result, $new_movie);
            }
        }

        $number_of_songs = $wpdb->get_var("SELECT COUNT(*) FROM codistan_songs WHERE song_type=1 AND status=true" . getFilterQuery());
        if($number_of_songs > 0){
            $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE song_type=1 AND status=true" . getFilterQuery());
            $all_songs = array();
            foreach ($songs as $song) {
                array_push($all_songs, array("id"=>$song->id, "name"=>$song->name, "type"=>$song->song_type, "language"=>$song->language, "genre"=>$song->genre, "url"=>$song->media_url, "year"=>$song->year));
            }
            $solo_songs = array("id"=>0, "name"=>"-Solo Songs", "songs"=>$all_songs);
            array_push($result, $solo_songs);
        }
        return $result;
    }

    function viewBySongs(){
        $songs = getResultsForView_Songs();

        ?>
            <table class="table table-hover table_songs">
                <?php
                    $count = 1;
                    foreach ($songs as $song) {

                        ?>
                            <tr><td>
                                <a href="/detail?content=song&id=<?php echo $song->id ?>" style="color:black" target="_blank">
                                <?php echo $count++ . ". " . $song->name; ?>
                                </a>
                                <div style="float: right;">
                                    <img width="20px" src="<?php echo plugins_url( '/images/play_count.png' , __FILE__ ); ?>">
                                    <?php echo getVideoViews($song->media_url); ?>
                                </div>
                            </td></tr>
                        <?php
                    }
                ?>
            </table>
        <?php
    }

    function getResultsForView_Songs(){
        global $wpdb;

        $songs;
        if(isset($_GET["sorting"]) && $_GET["sorting"] == "year"){
            if(isset($_GET["sorting_order"]) && $_GET["sorting_order"] == "desc")
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=true" . getFilterQuery() . " ORDER BY year DESC");
            else
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=true" . getFilterQuery() . " ORDER BY year");
        }
        else{
            if(isset($_GET["sorting_order"]) && $_GET["sorting_order"] == "desc")
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=true" . getFilterQuery() . " ORDER BY name DESC");
            else
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=true" . getFilterQuery() . " ORDER BY name");
        }
        return $songs;
    }

    function showFilters(){
        global $wpdb;
        ?>
            <b>FILTER RESULT</b>
            <form>
                <div class='form-group'>
                    <label for='filter_language' class='control-label'>Language</label>
                    <select class='form-control' id='filter_language' name='filter_language'>
                        <option value="0" >All</option>
                        <?php
                            $types = $wpdb->get_results("SELECT * FROM codistan_song_languages");
                            foreach ($types as $type) {
                                if($_SESSION["filter_language"] == $type->id)
                                    echo "<option value='".$type->id."' selected='selected'>".$type->name."</option>";
                                else
                                    echo "<option value='".$type->id."'>".$type->name."</option>";
                            }
                        ?>
                    </select>
                </div>
            </form>
        <?php
    }

    function getFilterQuery(){
        if($_SESSION["filter_language"] != 0)
            return " AND language=" . $_SESSION["filter_language"];
        return "";
    }
?>
