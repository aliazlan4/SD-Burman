<?php
    function main_form(){
        global $wpdb;

        if ( !is_user_logged_in() ){
            echo "<div class='text-center'>Error! You must be logged in to submit content!</div>";
            return;
        }

        if(isset($_POST['contributions_submit']))
            submitForm();
        else{

        ?>
            <form id='Contributions-form' method='post' action='' enctype='multipart/form-data' class='form-horizontal bordered'>
                <div class='form-group required'>
                    <label for='contributions_category' class='col-sm-4 control-label'>Category</label>
                    <div class='search col-sm-8'>
                        <select class='form-control' id='contributions_category' name='contributions_category'>
                            <option value='0'></option>
                            <?php
                                $types = $wpdb->get_results("SELECT * FROM codistan_content_types");
                                foreach ($types as $type) {
                                    echo "<option value='".$type->id."'>".$type->name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="song_form_div" style="display:none">
                    <div class='form-group required'>
                        <label for='contributions_song_name' class='col-sm-4 control-label'>Song Name</label>
                        <div class='search col-sm-8'>
                            <input class='form-control' type='text' id='contributions_song_name' name='contributions_song_name'>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_type' class='col-sm-4 control-label'>Song's Type</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_song_type' name='contributions_song_type'>
                                <?php
                                    $types = $wpdb->get_results("SELECT * FROM codistan_song_types");
                                    foreach ($types as $type) {
                                        echo "<option value='".$type->id."'>".$type->name."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_movie' class='col-sm-4 control-label'>Song's Movie</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_movie' name='contributions_movie' autocomplete='off'>
                                <ul class='results' id='search_results'></ul>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_lyricist' class='col-sm-4 control-label'>Song's Lyricist</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_lyricist' name='contributions_song_lyricist'>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_singer' class='col-sm-4 control-label'>Song's Singer</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_singer' name='contributions_song_singer'>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_language' class='col-sm-4 control-label'>Song's Language</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_song_language' name='contributions_song_language'>
                                <?php
                                    $types = $wpdb->get_results("SELECT * FROM codistan_song_languages");
                                    foreach ($types as $type) {
                                        echo "<option value='".$type->id."'>".$type->name."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_genre' class='col-sm-4 control-label'>Song's Genre</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_song_genre' name='contributions_song_genre'>
                                <?php
                                    $types = $wpdb->get_results("SELECT * FROM codistan_song_genres");
                                    foreach ($types as $type) {
                                        echo "<option value='".$type->id."'>".$type->name."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_url' class='col-sm-4 control-label'>Song's Youtube link</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_url' name='contributions_song_url'>
                        </div>
                    </div>

                    <div class='form-group required'>
                        <label for='contributions_song_year' class='col-sm-4 control-label'>Song's Year</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_year' name='contributions_song_year'>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="form_submit_row" style="display:none">
                    <div class="col-sm-offset-4 col-sm-8">
                          <input type="submit" id='contributions_submit' name='contributions_submit' class="btn btn-default">
                    </div>
                </div>
            </form>
        <?php
        }
    }
    add_shortcode( 'codistan_main_form', 'main_form' );

    function submitForm(){
        global $wpdb;

        $movie_id = $wpdb->get_var("SELECT id FROM codistan_movies WHERE name = '".$_POST["contributions_movie"]."'");

        if($_POST["contributions_category"] == "1" || $_POST["contributions_category"] == "2"){
            $wpdb->insert('codistan_songs',array("name"=>$_POST['contributions_song_name'], "song_type"=>$_POST['contributions_song_type'], "movie"=>$movie_id, "lyricist"=>$_POST['contributions_song_lyricist'], "singers"=>$_POST['contributions_song_singer'], "language"=>$_POST['contributions_song_language'], "genre"=>$_POST['contributions_song_genre'], "media_url"=>$_POST['contributions_song_url'], "year"=>$_POST['contributions_song_year'], "user"=>wp_get_current_user()->ID));
        }

        echo "Content Submit!";
    }
?>
