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

    function getMovie($id){
        global $wpdb;

        $temp = $wpdb->get_results("SELECT * FROM codistan_movies WHERE id=".$id);
        foreach ($temp as $temp1) {
            return $temp1->name;
        }
        return "";
    }

    function changeFilter(){
        if($_SESSION[$_POST["input"]])
            $_SESSION[$_POST["input"]] = false;
        else
            $_SESSION[$_POST["input"]] = true;
        wp_die();
    }

    function changeDirector(){
        $_SESSION["filter_director"] = $_POST["input"];
        wp_die();
    }

    function changeSinger(){
        $_SESSION["filter_singer"] = $_POST["input"];
        wp_die();
    }

    function changeSortBy(){
        $_SESSION["sort_by"] = $_POST["sort_by"];
        wp_die();
    }

    function searchMovie(){
        global $wpdb;
        $text = $_POST["text"];
        $json_string = '{"data":[';

        $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM codistan_movies WHERE name LIKE '%".$text."%'");
        if($rowcount > 0){
            $result = $wpdb->get_results("SELECT id,name FROM codistan_movies WHERE name LIKE '%".$text."%'");
            foreach($result as $row){
                $json_string .= '{"id":'.$row->id.', "title":"'.$row->name.'"},';
            }
            $json_string = rtrim($json_string, ",");
            $json_string .= "]}";
            die($json_string);
        }
        die("nothing");
    }

    function searchForRelatedTo(){
        global $wpdb;
        $text = $_POST["text"];
        $related = $_POST["related"];

        if($related == '2'){
            $json_string = '{"data":[';

            $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM codistan_songs WHERE name LIKE '%".$text."%'");
            if($rowcount > 0){
                $result = $wpdb->get_results("SELECT id,name FROM codistan_songs WHERE name LIKE '%".$text."%'");
                foreach($result as $row){
                    $json_string .= '{"id":'.$row->id.', "title":"'.$row->name.'"},';
                }
                $json_string = rtrim($json_string, ",");
                $json_string .= "]}";
                die($json_string);
            }
        }

        else if($related == '4'){
            $json_string = '{"data":[';

            $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM codistan_movies WHERE name LIKE '%".$text."%'");
            if($rowcount > 0){
                $result = $wpdb->get_results("SELECT id,name FROM codistan_movies WHERE name LIKE '%".$text."%'");
                foreach($result as $row){
                    $json_string .= '{"id":'.$row->id.', "title":"'.$row->name.'"},';
                }
                $json_string = rtrim($json_string, ",");
                $json_string .= "]}";
                die($json_string);
            }
        }

        else if($related == '5'){
            $json_string = '{"data":[';

            $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM codistan_articles WHERE name LIKE '%".$text."%'");
            if($rowcount > 0){
                $result = $wpdb->get_results("SELECT id,name FROM codistan_articles WHERE name LIKE '%".$text."%'");
                foreach($result as $row){
                    $json_string .= '{"id":'.$row->id.', "title":"'.$row->name.'"},';
                }
                $json_string = rtrim($json_string, ",");
                $json_string .= "]}";
                die($json_string);
            }
        }

        else if($related == '6'){
            $json_string = '{"data":[';

            $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM codistan_events WHERE name LIKE '%".$text."%'");
            if($rowcount > 0){
                $result = $wpdb->get_results("SELECT id,name FROM codistan_events WHERE name LIKE '%".$text."%'");
                foreach($result as $row){
                    $json_string .= '{"id":'.$row->id.', "title":"'.$row->name.'"},';
                }
                $json_string = rtrim($json_string, ",");
                $json_string .= "]}";
                die($json_string);
            }
        }
        die("nothing");
    }

    function upload_image($file){
		$target_dir = "wp-content/uploads/";
		$target_file = $target_dir . basename($file["name"]);
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$error = false;

		// Check file size
		if ($_FILES["contributions_upload"]["size"] > 5242880) {
			$message = "<b>Sorry, your image file is too large. Max File Size is 5MB.</b>";
			$error = true;
		}
		// Check if file already exists
		else if (file_exists($target_file)) {
			$message = "<b>Sorry, image file name already exists. Kindly rename your file.</b>";
			$error = true;
		}
		// Allow certain file formats
		else if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg") {
			$message = "<b>Sorry, only JPG, JPEG, PNG files are allowed.</b>";
			$error = true;
		}

		//Uploading File.
		else if (move_uploaded_file($file["tmp_name"], $target_file)) {
			$media_link = $target_file;
			$message = "<b>Image file uploaded.</b>";
		} else {
			$message = "Sorry, there was an error uploading your image file.";
			$error = true;
		}

		return ["error" => $error, "message" => $message, "image_path" => $target_file];
	}
?>
