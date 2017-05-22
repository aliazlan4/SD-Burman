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
                <div class='form-group'>
                    <label for='contributions_category' class='col-sm-4 control-label'>Category</label>
                    <div class='search col-sm-8'>
                        <select class='form-control' id='contributions_category' name='contributions_category'>
                            <option value='0'></option>
                            <option value='2'>Song</option>
                            <option value='3'>Image</option>
                            <option value='5'>Article</option>
                        </select>
                    </div>
                </div>
                <div id="song_form_div" style="display:none">
                    <div class='form-group'>
                        <label for='contributions_song_name' class='col-sm-4 control-label'>Song Name</label>
                        <div class='search col-sm-8'>
                            <input class='form-control' type='text' id='contributions_song_name' name='contributions_song_name' onfocus="remove_search_results()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_type' class='col-sm-4 control-label'>Song's Type</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_song_type' name='contributions_song_type' onfocus="remove_search_results()">
                                <?php
                                    $types = $wpdb->get_results("SELECT * FROM codistan_song_types");
                                    foreach ($types as $type) {
                                        echo "<option value='".$type->id."'>".$type->name."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_movie' class='col-sm-4 control-label'>Song's Movie</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_movie' name='contributions_movie' autocomplete='off'>
                                <ul class='results custom_scrollbar' id='search_results' style='max-height:300px; overflow-y: scroll;'></ul>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_lyricist' class='col-sm-4 control-label'>Song's Lyricist</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_lyricist' name='contributions_song_lyricist' onfocus="remove_search_results()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_singer' class='col-sm-4 control-label'>Song's Singer</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_singer' name='contributions_song_singer' onfocus="remove_search_results()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_language' class='col-sm-4 control-label'>Song's Language</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_song_language' name='contributions_song_language' onfocus="remove_search_results()">
                                <?php
                                    $types = $wpdb->get_results("SELECT * FROM codistan_song_languages");
                                    foreach ($types as $type) {
                                        echo "<option value='".$type->id."'>".$type->name."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_genre' class='col-sm-4 control-label'>Song's Genre</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_song_genre' name='contributions_song_genre' onfocus="remove_search_results()">
                                <?php
                                    $types = $wpdb->get_results("SELECT * FROM codistan_song_genres");
                                    foreach ($types as $type) {
                                        echo "<option value='".$type->id."'>".$type->name."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_url' class='col-sm-4 control-label'>Song's Youtube link</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_url' name='contributions_song_url' onfocus="remove_search_results()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_song_year' class='col-sm-4 control-label'>Song's Year</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_song_year' name='contributions_song_year' onfocus="remove_search_results()">
                        </div>
                    </div>
                </div>
                <div id="picture_form_div" style="display:none">
                    <div class='form-group'>
                        <label for='contributions_picture_relatedTo' class='col-sm-4 control-label'>Related To</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_picture_relatedTo' name='contributions_picture_relatedTo' onfocus="remove_search_results_picture()">
                                <option value='2'>Song</option>
                                <option value='4'>Movie</option>
                                <option value='5'>Article</option>
                                <option value='6'>Event</option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_picture_relatedToId' class='col-sm-4 control-label'>Name of Song/Movie/Event/Article</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_picture_relatedToId' name='contributions_picture_relatedToId' autocomplete='off'>
                                <ul class='results custom_scrollbar' id='search_results_picture_relatedToId' style='max-height:300px; overflow-y: scroll;'></ul>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_picture_name' class='col-sm-4 control-label'>Caption</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_picture_name' name='contributions_picture_name' onfocus="remove_search_results_picture()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_picture_pic' class='col-sm-4 control-label'>Image</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='file' id='contributions_picture_pic' name='contributions_picture_pic' accept='image/png,image/jpeg' onfocus="remove_search_results_picture()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_picture_year' class='col-sm-4 control-label'>Year</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_picture_year' name='contributions_picture_year' onfocus="remove_search_results_picture()">
                        </div>
                    </div>
                </div>
                <div id="article_form_div" style="display:none">
                    <div class='form-group'>
                        <label for='contributions_article_relatedTo' class='col-sm-4 control-label'>Related To</label>
                        <div class='search col-sm-8'>
                            <select class='form-control' id='contributions_article_relatedTo' name='contributions_article_relatedTo' onfocus="remove_search_results_article()">
                                <option value='2'>Song</option>
                                <option value='4'>Movie</option>
                                <option value='6'>Event</option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_relatedToId' class='col-sm-4 control-label'>Name of Song/Movie/Event</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_article_relatedToId' name='contributions_article_relatedToId' autocomplete='off'>
                                <ul class='results custom_scrollbar' id='search_results_article_relatedToId' style='max-height:300px; overflow-y: scroll;'></ul>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_name' class='col-sm-4 control-label'>Heading</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_article_name' name='contributions_article_name' onfocus="remove_search_results_article()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_content' class='col-sm-4 control-label'>Content</label>
                        <div class='search col-sm-8'>
                            <textarea class="form-control" rows="4" id='contributions_article_content' name='contributions_article_content' onfocus="remove_search_results_article()"></textarea>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_pic' class='col-sm-4 control-label'>Image</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='file' id='contributions_article_pic' name='contributions_article_pic' accept='image/png,image/jpeg' onfocus="remove_search_results_article()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_url' class='col-sm-4 control-label'>Video Youtube link</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_article_url' name='contributions_article_url' onfocus="remove_search_results_article()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_author' class='col-sm-4 control-label'>Author</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_article_author' name='contributions_article_author' onfocus="remove_search_results_article()">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contributions_article_year' class='col-sm-4 control-label'>Year</label>
                        <div class='search col-sm-8'>
                                <input class='form-control' type='text' id='contributions_article_year' name='contributions_article_year' onfocus="remove_search_results_article()">
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
        if($_POST["contributions_category"] == "1" || $_POST["contributions_category"] == "2")
            submitSong();
        else if($_POST["contributions_category"] == "3")
            submitImage();
        else if($_POST["contributions_category"] == "5")
            submitArticle();
    }

    function submitSong(){
        global $wpdb;

        $movie_id = $wpdb->get_var("SELECT id FROM codistan_movies WHERE name = '".$_POST["contributions_movie"]."'");

        $wpdb->insert('codistan_songs',array("name"=>$_POST['contributions_song_name'], "song_type"=>$_POST['contributions_song_type'], "movie"=>$movie_id, "lyricist"=>$_POST['contributions_song_lyricist'], "singers"=>$_POST['contributions_song_singer'], "language"=>$_POST['contributions_song_language'], "genre"=>$_POST['contributions_song_genre'], "media_url"=>$_POST['contributions_song_url'], "year"=>$_POST['contributions_song_year'], "user"=>wp_get_current_user()->ID));

        echo "Song Submitted!";
    }

    function submitImage(){
        global $wpdb;

        $result = null;
        if (is_uploaded_file($_FILES["contributions_picture_pic"]['tmp_name']))
            $result = upload_image($_FILES["contributions_picture_pic"]);

        $relatedTo_id;

        if($_POST['contributions_picture_relatedTo'] == '2'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_songs WHERE name = '".$_POST["contributions_picture_relatedToId"]."'");
        }
        else if($_POST['contributions_picture_relatedTo'] == '4'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_movies WHERE name = '".$_POST["contributions_picture_relatedToId"]."'");
        }
        else if($_POST['contributions_picture_relatedTo'] == '5'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_articles WHERE name = '".$_POST["contributions_picture_relatedToId"]."'");
        }
        else if($_POST['contributions_picture_relatedTo'] == '6'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_events WHERE name = '".$_POST["contributions_picture_relatedToId"]."'");
        }

        if(!$result["error"]){
            $wpdb->insert('codistan_images',array("name"=>$_POST['contributions_picture_name'], "relatedTo"=>$_POST['contributions_picture_relatedTo'], "relatedTo_id"=>$relatedTo_id, "media_url"=>$result["image_path"], "year"=>$_POST['contributions_picture_year'], "user"=>wp_get_current_user()->ID));
            echo "Image Submit!";
        }
        else{
            echo $result["message"];
        }
    }

    function submitArticle(){
        global $wpdb;

        $result = null;
        if (is_uploaded_file($_FILES["contributions_article_pic"]['tmp_name']))
            $result = upload_image($_FILES["contributions_article_pic"]);

        $relatedTo_id;
        if($_POST['contributions_article_relatedTo'] == '2'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_songs WHERE name = '".$_POST["contributions_article_relatedToId"]."'");
        }
        else if($_POST['contributions_article_relatedTo'] == '4'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_movies WHERE name = '".$_POST["contributions_article_relatedToId"]."'");
        }
        else if($_POST['contributions_article_relatedTo'] == '5'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_articles WHERE name = '".$_POST["contributions_article_relatedToId"]."'");
        }
        else if($_POST['contributions_article_relatedTo'] == '6'){
            $relatedTo_id = $wpdb->get_var("SELECT id FROM codistan_events WHERE name = '".$_POST["contributions_article_relatedToId"]."'");
        }

        if(!$result["error"]){
            $wpdb->insert('codistan_articles',array("name"=>$_POST['contributions_article_name'], "relatedTo"=>$_POST['contributions_article_relatedTo'], "relatedTo_id"=>$relatedTo_id, "content"=>$_POST['contributions_article_content'], "image"=>$result["image_path"], "video_url"=>$_POST['contributions_article_url'], "author"=>$_POST['contributions_article_author'], "year"=>$_POST['contributions_article_year'], "user"=>wp_get_current_user()->ID));
            echo "Article Submitted!";
        }
        else{
            echo $result["message"];
        }
    }


?>
