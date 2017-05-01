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

function change_sorting(sorting, sorting_order){
	var result = "";
	if(sorting == "year"){
		result = "?sorting=year";
		if(sorting_order == "desc")
			result = result + "&sorting_order=desc";
	}
	else{
		if(sorting_order == "desc")
			result = "?sorting_order=desc";
	}

	result = "http://" + window.location.hostname + window.location.pathname + result;
	window.location = result;
}

jQuery(document).ready(function($) {
	$('#filter_language').on('change', function() {
	  	var option = this.value;
		jQuery.ajax({
			type: 'POST',
			url: MyAjax.ajaxurl,
			data: {"action": "changeLanguage", "filter_language":option},
			success: function(data){
		    	location.reload();
			}
		});
	})
});

jQuery(document).ready(function($) {
	$("#search_song").keypress(function(e) {
		if(e.which == 13) {
			var win = window.open("http://" + window.location.hostname + "/search?keyword=" + this.value, '_blank');
			win.focus();
	    }
	});
});

function play_song(url){
	var player = document.getElementById('video_player');
	url = url.replace("watch?v=", "embed/");
	player.src = url;
	player.parentNode.style.display = "";
}
