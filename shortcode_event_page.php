<?php
    function event_page(){
        global $wpdb;

        ?>
            <div class='row' style="padding:30px" id="articles_div">
                <p style='font-size:24px' class='text-center'><b>ARTICLES</b></p>
                <div class='row'>
                <?php
                    $articles = $wpdb->get_results("SELECT * FROM codistan_articles WHERE status=true AND relatedTo=6");
                    $count = 1;
                    foreach ($articles as $article) {
                        ?>
                            <a href="/detail?content=article&id=<?php echo $article->id; ?>" style="color:black;">
                                <div class='col-sm-3 text-center'>
                                    <img src='/<?php echo $article->image; ?>' style='padding:10px'></br>
                                    <b><?php echo $article->name; ?></b></br>
                                    By <?php echo $article->author; ?>
                                </div>
                            </a>
                        <?php
                        if($count++ % 4 == 0)
                            echo "</div><div class='row'>";
                    }
                ?>
                </div>
            </div>
        <?php
    }
    add_shortcode( 'codistan_event_page', 'event_page' );
?>
