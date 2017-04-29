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
