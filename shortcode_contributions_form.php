<?php
    function main_form(){
        global $wpdb;

        ?>
            <h3>Add New Contributions</h3></br>

            <form id='Contributions-form' method='post' action='' enctype='multipart/form-data' class='form-horizontal bordered'>
                <div class='form-group'>
                      <div class='col-sm-12'>
                                <div align='center' class='lead'><b>Contribute</b></div>
                      </div>
                </div>

                <div class='form-group required'>
                    <label for='contributions_category' class='col-sm-4 control-label'>Category</label>
                    <div class='search col-sm-8'>
                        <select class='form-control' id='contributions_category' name='contributions_category'>
                            <?php
                                $types = $wpdb->get_results("SELECT * FROM codistan_content_types");
                                foreach ($types as $type) {
                                    echo "<option value='".$type->id."'>".$type->name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class='form-group required'>
                    <label for='contributions_type' class='col-sm-4 control-label'>Song Type</label>
                    <div class='search col-sm-8'>
                        <select class='form-control' id='contributions_type' name='contributions_type'>
                            <?php
                                $types = $wpdb->get_results("SELECT * FROM codistan_song_types");
                                foreach ($types as $type) {
                                    echo "<option value='".$type->id."'>".$type->name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </form>
        <?php
    }
    add_shortcode( 'codistan_main_form', 'main_form' );
?>
