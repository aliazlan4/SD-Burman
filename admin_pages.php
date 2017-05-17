<?php
	defined('ABSPATH') or die("No script kiddies please!");

	function codistan_new_contributions(){
		new_songs();
		new_images();
		new_articles();
	}

	function new_songs(){
		global $wpdb;
		?>
		<div class="row">
			<h2 class="text-center">Songs</h2>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
				<table class="table table-striped table-bordered" id="songs_table">
					<tr>
						<th>Sr.</th>
						<th>User</th>
						<th>Name</th>
						<th>Type</th>
						<th>Movie</th>
						<th>Lyricist</th>
						<th>Singer</th>
						<th>Genre</th>
						<th>Youtube link</th>
						<th>Year</th>
						<th>Approve</th>
						<th>Delete</th>
					</tr>
					<?php
						$songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=false");
						$count = 1;
						foreach($songs as $song){
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo get_userdata($song->user)->user_login; ?></td>
									<td><?php echo $song->name; ?></td>
									<td><?php echo getSongType($song->song_type); ?></td>
									<td><?php echo getMovie($song->movie); ?></td>
									<td><?php echo $song->lyricist; ?></td>
									<td><?php echo $song->singers; ?></td>
									<td><?php echo getGenre($song->genre); ?></td>
									<td><a href='<?php echo $song->media_url; ?>'>Click here</a></td>
									<td><?php echo $song->year; ?></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/approve.png' , __FILE__ ); ?>'  onClick='approveSong(<?php echo $song->id; ?>,this);'></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/delete.png' , __FILE__ ); ?>'  onClick='deleteSong(<?php echo $song->id; ?>,this);'></td>
								</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<?php
	}

	function new_images(){
		global $wpdb;
		?>
		<div class="row">
			<h2 class="text-center">Images</h2>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
				<table class="table table-striped table-bordered" id="images_table">
					<tr>
						<th>Sr.</th>
						<th>User</th>
						<th>Caption</th>
						<th>URL</th>
						<th>Related To</th>
						<th>Related To Name</th>
						<th>Year</th>
						<th>Approve</th>
						<th>Delete</th>
					</tr>
					<?php
						$images = $wpdb->get_results("SELECT * FROM codistan_images WHERE status=false");
						$count = 1;
						foreach($images as $image){
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo get_userdata($image->user)->user_login; ?></td>
									<td><?php echo $image->name; ?></td>
									<td><a href='/<?php echo $image->media_url; ?>'>Click here</a></td>
									<td>
										<?php
											if($image->relatedTo == "2")
												echo "Song";
											else if($image->relatedTo == "4")
												echo "Movie";
											else if($image->relatedTo == "5")
												echo "Article";
											else if($image->relatedTo == "6")
												echo "Event";
										?>
									</td>
									<td>
										<?php
											if($image->relatedTo == "2")
												echo getSong($image->relatedTo_id);
											else if($image->relatedTo == "4")
												echo getMovie($image->relatedTo_id);
											else if($image->relatedTo == "5")
												echo getArticle($image->relatedTo_id);
											else if($image->relatedTo == "6")
												echo getEvent($image->relatedTo_id);
										?>
									</td>
									<td><?php echo $image->year; ?></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/approve.png' , __FILE__ ); ?>'  onClick='approveImage(<?php echo $image->id; ?>,this);'></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/delete.png' , __FILE__ ); ?>'  onClick='deleteImage(<?php echo $image->id; ?>,this);'></td>
								</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<?php
	}

	function new_articles(){
		global $wpdb;
		?>
		<div class="row">
			<h2 class="text-center">Articles</h2>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
				<table class="table table-striped table-bordered" id="articles_table">
					<tr>
						<th>Sr.</th>
						<th>User</th>
						<th>Name</th>
						<th>Content</th>
						<th>Author</th>
						<th>Image</th>
						<th>Video</th>
						<th>Related To</th>
						<th>Related To Name</th>
						<th>Year</th>
						<th>Approve</th>
						<th>Delete</th>
					</tr>
					<?php
						$articles = $wpdb->get_results("SELECT * FROM codistan_articles WHERE status=false");
						$count = 1;
						foreach($articles as $article){
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo get_userdata($article->user)->user_login; ?></td>
									<td><?php echo $article->name; ?></td>
									<td><?php echo $article->content; ?></td>
									<td><?php echo $article->author; ?></td>
									<td><a href='/<?php echo $article->image; ?>'>Click here</a></td>
									<td><a href='<?php echo $article->video_url; ?>'>Click here</a></td>
									<td>
										<?php
											if($article->relatedTo == "2")
												echo "Song";
											else if($article->relatedTo == "4")
												echo "Movie";
											else if($article->relatedTo == "5")
												echo "Article";
											else if($article->relatedTo == "6")
												echo "Event";
										?>
									</td>
									<td>
										<?php
											if($article->relatedTo == "2")
												echo getSong($article->relatedTo_id);
											else if($article->relatedTo == "4")
												echo getMovie($article->relatedTo_id);
											else if($article->relatedTo == "5")
												echo getArticle($article->relatedTo_id);
											else if($article->relatedTo == "6")
												echo getEvent($article->relatedTo_id);
										?>
									</td>
									<td><?php echo $article->year; ?></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/approve.png' , __FILE__ ); ?>'  onClick='approveArticle(<?php echo $article->id; ?>,this);'></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/delete.png' , __FILE__ ); ?>'  onClick='deleteArticle(<?php echo $article->id; ?>,this);'></td>
								</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<?php
	}

	function codistan_approved_contributions(){
		approved_songs();
		approved_images();
		approved_articles();
	}

	function approved_songs(){
		global $wpdb;
		?>
		<div class="row">
			<h2 class="text-center">Songs</h2>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
				<table class="table table-striped table-bordered" id="songs_table">
					<tr>
						<th>Sr.</th>
						<th>User</th>
						<th>Name</th>
						<th>Type</th>
						<th>Movie</th>
						<th>Lyricist</th>
						<th>Singer</th>
						<th>Genre</th>
						<th>Youtube link</th>
						<th>Year</th>
						<th>Delete</th>
					</tr>
					<?php
						$songs = $wpdb->get_results("SELECT * FROM codistan_songs WHERE status=true");
						$count = 1;
						foreach($songs as $song){
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo get_userdata($song->user)->user_login; ?></td>
									<td><?php echo $song->name; ?></td>
									<td><?php echo getSongType($song->song_type); ?></td>
									<td><?php echo getMovie($song->movie); ?></td>
									<td><?php echo $song->lyricist; ?></td>
									<td><?php echo $song->singers; ?></td>
									<td><?php echo getGenre($song->genre); ?></td>
									<td><a href='<?php echo $song->media_url; ?>'>Click here</a></td>
									<td><?php echo $song->year; ?></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/delete.png' , __FILE__ ); ?>'  onClick='deleteSong(<?php echo $song->id; ?>,this);'></td>
								</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<?php
	}

	function approved_images(){
		global $wpdb;
		?>
		<div class="row">
			<h2 class="text-center">Images</h2>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
				<table class="table table-striped table-bordered" id="images_table">
					<tr>
						<th>Sr.</th>
						<th>User</th>
						<th>Caption</th>
						<th>URL</th>
						<th>Related To</th>
						<th>Related To Name</th>
						<th>Year</th>
						<th>Delete</th>
					</tr>
					<?php
						$images = $wpdb->get_results("SELECT * FROM codistan_images WHERE status=true");
						$count = 1;
						foreach($images as $image){
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo get_userdata($image->user)->user_login; ?></td>
									<td><?php echo $image->name; ?></td>
									<td><a href='/<?php echo $image->media_url; ?>'>Click here</a></td>
									<td>
										<?php
											if($image->relatedTo == "2")
												echo "Song";
											else if($image->relatedTo == "4")
												echo "Movie";
											else if($image->relatedTo == "5")
												echo "Article";
											else if($image->relatedTo == "6")
												echo "Event";
										?>
									</td>
									<td>
										<?php
											if($image->relatedTo == "2")
												echo getSong($image->relatedTo_id);
											else if($image->relatedTo == "4")
												echo getMovie($image->relatedTo_id);
											else if($image->relatedTo == "5")
												echo getArticle($image->relatedTo_id);
											else if($image->relatedTo == "6")
												echo getEvent($image->relatedTo_id);
										?>
									</td>
									<td><?php echo $image->year; ?></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/delete.png' , __FILE__ ); ?>'  onClick='deleteImage(<?php echo $image->id; ?>,this);'></td>
								</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<?php
	}

	function approved_articles(){
		global $wpdb;
		?>
		<div class="row">
			<h2 class="text-center">Articles</h2>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 custom_scrollbar" style='max-height:400px; overflow-y: scroll;'>
				<table class="table table-striped table-bordered" id="articles_table">
					<tr>
						<th>Sr.</th>
						<th>User</th>
						<th>Name</th>
						<th>Content</th>
						<th>Author</th>
						<th>Image</th>
						<th>Video</th>
						<th>Related To</th>
						<th>Related To Name</th>
						<th>Year</th>
						<th>Delete</th>
					</tr>
					<?php
						$articles = $wpdb->get_results("SELECT * FROM codistan_articles WHERE status=true");
						$count = 1;
						foreach($articles as $article){
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo get_userdata($article->user)->user_login; ?></td>
									<td><?php echo $article->name; ?></td>
									<td><?php echo $article->content; ?></td>
									<td><?php echo $article->author; ?></td>
									<td><a href='/<?php echo $article->image; ?>'>Click here</a></td>
									<td><a href='<?php echo $article->video_url; ?>'>Click here</a></td>
									<td>
										<?php
											if($article->relatedTo == "2")
												echo "Song";
											else if($article->relatedTo == "4")
												echo "Movie";
											else if($article->relatedTo == "5")
												echo "Article";
											else if($article->relatedTo == "6")
												echo "Event";
										?>
									</td>
									<td>
										<?php
											if($article->relatedTo == "2")
												echo getSong($article->relatedTo_id);
											else if($article->relatedTo == "4")
												echo getMovie($article->relatedTo_id);
											else if($article->relatedTo == "5")
												echo getArticle($article->relatedTo_id);
											else if($article->relatedTo == "6")
												echo getEvent($article->relatedTo_id);
										?>
									</td>
									<td><?php echo $article->year; ?></td>
									<td><input type='image' align='center' src='<?php echo plugins_url( '/images/delete.png' , __FILE__ ); ?>'  onClick='deleteArticle(<?php echo $article->id; ?>,this);'></td>
								</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<?php
	}
?>
