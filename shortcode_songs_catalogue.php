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
        $movies = getResultsForView_Movies();
        foreach ($movies as $movie) {
        ?>
        <div class="row form-group" id="player_div_<?php echo $movie["id"]; ?>" style="margin-right:0px;display:none">
            <div class="col-md-8">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" id="songs_player_<?php echo $movie["id"]; ?>" width="100%" height="400px" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-4 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
                <?php
                    foreach ($movie["songs"] as $song) {
                        ?>
                            <div class="row featured_list" onclick="changeSong_Catalogue(<?php echo $movie["id"]; ?>, '<?php echo $song["url"]; ?>');" href="#">
                                <div class="col-md-4">
                                    <img src="<?php echo getVideoThumbnail($song["url"]); ?>">
                                </div>
                                <div class="col-md-8 lead">
                                    <?php echo $song["name"]; ?>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <?php
                if(count($movies) < 1)
                    echo "<h5 class='text-center'>No Content Found!</h5>";
                else{
                    $count = 1;
                    foreach ($movies as $movie) {
                        ?>
                        <div class="col-md-4 text-center" style="padding-bottom:50px">
                            <img class="play" src="<?php echo plugins_url( '/images/play.png' , __FILE__ ); ?>" onclick="play_song_catalogue(<?php echo $movie["id"]; ?>, '<?php echo $movie["songs"][0]["url"]; ?>')">
                             <?php if($movie["image"] != null && $movie["image"] != ""){ ?>
                            <img width="200px" height="250px" src="<?php echo "/wp-content/uploads/codistan/" . $movie["image"]; ?>">
                            <?php } else { ?>
                                <img width="200px" height="250px" src="http://c.saavncdn.com/001/S-D-Burman-The-Evergreen-Composer-2013-500x500.jpg">
                            <?php } ?>
                            </br>
                            <a href="/detail?content=movie&id=<?php echo $movie["id"]; ?>" style="color:black;">
                                <h5>
                                    <?php echo $movie["name"]; ?>
                                    </br>
                                    <?php if($movie["id"] != "0") echo "(" . $movie["year"] . ")"; ?>
                                </h5>
                            </a>
                            <div class="border_bottom"></div>
                            <?php if($movie["id"] != "0") echo "Director: " . $movie["director"]; ?></br>
                        </div>
                        <?php
                        if($count++ % 3 == 0)
                            echo "</div><div class='row'>";
                    }
                }
            ?>

            </div>
        <?php
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
            $solo_songs = array("id"=>0, "name"=>"Solo Songs", "songs"=>$all_songs);
            array_push($result, $solo_songs);
        }
        return $result;
    }

    function viewBySongs(){
        $songs = getResultsForView_Songs();
        ?>
            <div class="row">
        <?php
            if(count($songs) < 1)
                echo "<h5 class='text-center'>No Content Found!</h5>";
            else{
                $count = 1;
                foreach ($songs as $song) {
                    ?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="">
                                <a href="/detail?content=song&id=<?php echo $song->id ?>"><img src="<?php echo getVideoThumbnail($song->media_url); ?>"></a>
                            </div>
                            <div class="panel-footer">
                                <a href="/detail?content=song&id=<?php echo $song->id ?>" style="color:black"><b><?php echo $song->name; ?></b></a></br>
                                <a href="/detail?content=movie&id=<?php echo $song->movie ?>" style="color:black">Movie: <?php echo getMovie($song->movie); ?></a></br>
                                Genre: <?php echo getGenre($song->genre); ?></br>
                                Year: <?php echo $song->year; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($count++ % 4 == 0)
                        echo "</div><div class='row'>";
                }
            }
        ?>

            </div>
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
                $songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=true" . getFilterQuery() . " ORDER BY name ASC");
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
