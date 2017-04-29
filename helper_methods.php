<?php
    function getVideoThumbnail($video_url){
        $video_url = str_replace("https://www", "https://img", $video_url);
        $video_url = str_replace("watch?v=", "vi/", $video_url);
        $video_url = $video_url . "/0.jpg";
        return $video_url;
    }
?>
