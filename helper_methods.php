<?php
    function getVideoThumbnail($video_url){
        $video_url = str_replace("https://www", "https://img", $video_url);
        $video_url = str_replace("watch?v=", "vi/", $video_url);
        $video_url = $video_url . "/0.jpg";
        return $video_url;
    }

    function getVideoCode($video_url){
        return str_replace("https://www.youtube.com/watch?v=", "", $video_url);
    }

    function getVideoViews($video_url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/youtube/v3/videos?part=statistics&id=".getVideoCode($video_url)."&key=AIzaSyDRxYGYDBv3sKhOYjsRXNhUO6YdV52G2f0");
        $result = curl_exec($ch);
        $json_data = json_decode($result, true);
        curl_close($ch);
        return $json_data['items'][0]['statistics']['viewCount'];
    }

    function getLanguage($id){
        global $wpdb;

        $temp = $wpdb->get_results("SELECT * FROM codistan_song_languages WHERE id=".$id);
        foreach ($temp as $temp1) {
            return $temp1->name;
        }
        return "";
    }

    function getGenre($id){
        global $wpdb;

        $temp = $wpdb->get_results("SELECT * FROM codistan_song_genres WHERE id=".$id);
        foreach ($temp as $temp1) {
            return $temp1->name;
        }
        return "";
    }

    function changeLanguage(){
        $_SESSION["filter_language"] = $_POST["filter_language"];
        wp_die();
    }

    function changeSortBy(){
        $_SESSION["sort_by"] = $_POST["sort_by"];
        wp_die();
    }
?>
