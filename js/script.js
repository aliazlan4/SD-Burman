jQuery(document).ready(function($) {
	$( "#contribute_button" ).click(function() {
		$("#Contributions-form").empty();
	});
});

function changeFeaturedSong(url){
    url = url.replace("watch?v=", "embed/");
    var player = document.getElementById('featured_songs_player');
    player.src = url;
}

var current_player;
var current_table;
function catalogue_play_song(movie, url, language, genre, year){
	jQuery(document).ready(function($) {
		document.getElementById('song_detail_language_' + movie).innerHTML = language;
	    document.getElementById('song_detail_genre_' + movie).innerHTML = genre;
	    document.getElementById('song_detail_year_' + movie).innerHTML = year;
	});

    var player = document.getElementById('player_' + movie);
	var table =  document.getElementById('song_detail_table_' + movie);

    url = url.replace("watch?v=", "embed/");
    player.src = url;

    if(current_player != player){
        if(current_player != null){
			current_player.parentNode.style.display = "none";
            current_player.src = "";

            current_table.style.display = "none";
        }
        current_player = player;
        current_table = table;
    }

    player.parentNode.style.display = "";
    table.style.display = "table";
}
