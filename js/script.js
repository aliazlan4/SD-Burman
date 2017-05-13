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

	if(url != "N/A")
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

jQuery(document).ready(function($) {
$( function() {
    $('#contributions_movie').keyup(function () {
		var text = $('#contributions_movie').val();

		if(text.length > 2){
			jQuery.ajax({
				type: 'POST',
				url: MyAjax.ajaxurl,
				data: {"action": "searchMovie", "text":text},
				success: function(data){
					if(data == ""){
						remove_search_results();
					}
					else{
						show_search_results(data);
					}
				}
			});
		}
		else{
			remove_search_results();
		}
	});
  });
});

function show_search_results(data){
	remove_search_results();

	jQuery(".results").css("display", "block");
	var json = JSON.parse(data);
	var div = document.getElementById("search_results");

	for(var i = 0; i < json.data.length; i++){
		var temp = document.createElement('li');
		var temp1 = document.createElement('a');
        temp1.textContent = json.data[i].title;
		temp.setAttribute("onclick","redirect_search_result(this, '" + json.data[i].title + "');");

		temp.appendChild(temp1);
        div.appendChild(temp);
	}

}

function remove_search_results(){
 	jQuery('#search_results').empty();
	jQuery(".results").css("display", "none");
}

function redirect_search_result(obj, title){
	var a = obj.childNodes[0];
	document.getElementById("contributions_movie").value = a.textContent;
	jQuery(".results").css("display", "none");
}

jQuery(document).ready(function($) {
$( function() {
    $('#contributions_picture_relatedToId').keyup(function () {
		var text = $('#contributions_picture_relatedToId').val();
		var related = $('#contributions_picture_relatedTo').val();

		if(text.length > 2){
			jQuery.ajax({
				type: 'POST',
				url: MyAjax.ajaxurl,
				data: {"action": "searchForRelatedTo", "text":text, "related":related},
				success: function(data){
					if(data == ""){
						remove_search_results_picture();
					}
					else{
						show_search_results_picture(data);
					}
				}
			});
		}
		else{
			remove_search_results_picture();
		}
	});
  });
});

function show_search_results_picture(data){
	remove_search_results_picture();

	jQuery(".results").css("display", "block");
	var json = JSON.parse(data);
	var div = document.getElementById("search_results_picture_relatedToId");

	for(var i = 0; i < json.data.length; i++){
		var temp = document.createElement('li');
		var temp1 = document.createElement('a');
        temp1.textContent = json.data[i].title;
		temp.setAttribute("onclick","redirect_search_result_picture(this, '" + json.data[i].title + "');");

		temp.appendChild(temp1);
        div.appendChild(temp);
	}

}

function remove_search_results_picture(){
 	jQuery('#search_results_picture_relatedToId').empty();
	jQuery(".results").css("display", "none");
}

function redirect_search_result_picture(obj, title){
	var a = obj.childNodes[0];
	document.getElementById("contributions_picture_relatedToId").value = a.textContent;
	jQuery(".results").css("display", "none");
}

jQuery(document).ready(function($) {
$( function() {
    $('#contributions_article_relatedToId').keyup(function () {
		var text = $('#contributions_article_relatedToId').val();
		var related = $('#contributions_article_relatedTo').val();

		if(text.length > 2){
			jQuery.ajax({
				type: 'POST',
				url: MyAjax.ajaxurl,
				data: {"action": "searchForRelatedTo", "text":text, "related":related},
				success: function(data){
					if(data == ""){
						remove_search_results_article();
					}
					else{
						show_search_results_article(data);
					}
				}
			});
		}
		else{
			remove_search_results_article();
		}
	});
  });
});

function show_search_results_article(data){
	remove_search_results_article();

	jQuery(".results").css("display", "block");
	var json = JSON.parse(data);
	var div = document.getElementById("search_results_article_relatedToId");

	for(var i = 0; i < json.data.length; i++){
		var temp = document.createElement('li');
		var temp1 = document.createElement('a');
        temp1.textContent = json.data[i].title;
		temp.setAttribute("onclick","redirect_search_result_article(this, '" + json.data[i].title + "');");

		temp.appendChild(temp1);
        div.appendChild(temp);
	}

}

function remove_search_results_article(){
 	jQuery('#search_results_article_relatedToId').empty();
	jQuery(".results").css("display", "none");
}

function redirect_search_result_article(obj, title){
	var a = obj.childNodes[0];
	document.getElementById("contributions_article_relatedToId").value = a.textContent;
	jQuery(".results").css("display", "none");
}

jQuery(document).ready(function($) {
	$('#contributions_category').on('change', function() {
		document.getElementById("song_form_div").style.display = 'none';
		document.getElementById("picture_form_div").style.display = 'none';
		document.getElementById("article_form_div").style.display = 'none';
		document.getElementById("form_submit_row").style.display = 'none';

		if(this.value == "1" || this.value == "2"){
	  		document.getElementById("song_form_div").style.display = '';
	  		document.getElementById("form_submit_row").style.display = '';
		}
		else if(this.value == "3"){
			document.getElementById("picture_form_div").style.display = '';
	  		document.getElementById("form_submit_row").style.display = '';
		}
		else if(this.value == "5"){
			document.getElementById("article_form_div").style.display = '';
			document.getElementById("form_submit_row").style.display = '';
		}
	});
});
