<?php
    function search_page(){
        $songs = getResultofSearch($_GET["keyword"]);
        ?>
            <h3 class="text-center" style="padding:15px;">Search Results</h3></br>
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
                            <div class="panel-body">
                                <a href="/detail?content=song&id=<?php echo $song->id ?>"><img src="<?php echo getVideoThumbnail($song->media_url); ?>"></a>
                            </div>
                            <div class="panel-footer">
                                <a href="/detail?content=song&id=<?php echo $song->id ?>" style="color:black"><b><?php echo $song->name; ?></b></a></br>
                                <a href="/detail?content=movie&id=<?php echo $song->movie ?>" style="color:black">Movie: <?php echo $song->movie_name; ?></a></br>
                                Genre: <?php echo $song->genre_name; ?></br>
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
    add_shortcode( 'codistan_search_page', 'search_page' );

    function getResultofSearch($keyword){
        global $wpdb;
        return $wpdb->get_results("
            SELECT
            s.*,
            l.name as language_name,
            g.name as genre_name,
            t.name as type_name,
            m.name as movie_name,
            m.director as movie_director,
            m.producer as movie_producer,
            m.description as movie_description,
            m.singers as movie_singers,
            m.actors as movie_actors
            FROM
            codistan_songs s
            LEFT OUTER JOIN codistan_movies m ON s.movie = m.id
            LEFT OUTER JOIN codistan_song_languages l ON s.language = l.id
            LEFT OUTER JOIN codistan_song_genres g ON s.genre = g.id
            LEFT OUTER JOIN codistan_song_types t ON s.song_type = t.id
            WHERE status=true
            AND (
                s.name LIKE '%". $keyword ."%'
                OR s.lyricist LIKE '%". $keyword ."%'
                OR s.director LIKE '%". $keyword ."%'
                OR s.singers LIKE '%". $keyword ."%'
                OR s.year LIKE '%". $keyword ."%'
                OR l.name LIKE '%". $keyword ."%'
                OR g.name LIKE '%". $keyword ."%'
                OR t.name LIKE '%". $keyword ."%'
                OR m.name LIKE '%". $keyword ."%'
                OR m.director LIKE '%". $keyword ."%'
                OR m.producer LIKE '%". $keyword ."%'
                OR m.description LIKE '%". $keyword ."%'
                OR m.singers LIKE '%". $keyword ."%'
                OR m.actors LIKE '%". $keyword ."%'
            )
        ");
    }
?>
