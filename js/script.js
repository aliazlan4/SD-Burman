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

function changeSong_Catalogue(id, url){
	url = url.replace("watch?v=", "embed/");
    var player = document.getElementById('songs_player_' + id);
    player.src = url;
}

var current_div;
var current_player;
function play_song_catalogue(id, url){
	var div = document.getElementById('player_div_' + id);
	var player = document.getElementById('songs_player_' + id);
	url = url.replace("watch?v=", "embed/");

	if(div != current_div){
		if(current_div != null){
			current_player.src = "";
			current_div.style.display = "none";
		}
		current_div = div;
		current_player = player;
	}

	player.src = url;
	div.style.display = "";

	$('html, body').animate({
        scrollTop: $("#" + "player_div_" + id).offset().top
    }, 500);
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
	$('#sort_by_list').on('change', function() {
	  	var option = this.value;
		jQuery.ajax({
			type: 'POST',
			url: MyAjax.ajaxurl,
			data: {"action": "changeSortBy", "sort_by":option},
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
