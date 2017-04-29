<?php
	defined('ABSPATH') or die("No script kiddies please!");

	function codistan_new_contributions(){
		echo "<h1 align='center'><b>New Contributions</b></h1>";
		echo "<hr></br>";

		echo "<table align='center' border='1px' id='codistan_table'>";
		echo "<tr><th>Sr.</th><th>Username</th><th>Title</th><th>Descripton</th><th>Media Type</th><th>Media Link</th><th>Time</th><th>Approve</th><th>Delete</th></tr>";

		global $wpdb;
		$result = $wpdb->get_results( "SELECT * FROM codistan_contributions WHERE status=false");
		$count = 1;
		foreach($result as $row){
			$link;
			if($row->file_uploaded)
				$link = site_url() . "/" . $row->media_link;
			else
				$link = $row->media_link;

			$result = $wpdb->get_results( "SELECT * FROM codistan_media WHERE id='". $row->media_id . "'");
			$media_info;
			foreach($result as $row1){
				$media_info = $row1;
				break;
			}

			$username = "Guest";
			if(get_userdata($row->user_id)->user_login != "")
					$username = get_userdata($row->user_id)->user_login;

			echo "<tr><td>".$count++."</td>
					<td>".  $username . "</td>
					<td><a target='_blank' href='/".media_page_url()."/?id=".$media_info->id."'>".$media_info->title."</td><td>".$row->description."</td>
					<td>".$row->media_type."</td>
					<td><a target='_blank' href='".$link."'>Click Here</a></td>
					<td>".$row->time."</td>
					<td><input type='image' align='center' src='".plugins_url( '/images/approve.png' , __FILE__ )."'  onClick='approveRecord(". $row->id .",this);'></td>
					<td><input type='image' align='center' src='".plugins_url( '/images/delete.png' , __FILE__ )."'  onClick='deleteRecord(". $row->id .",this);'></td>
				</tr>";
		}

		echo "</table>";
	}

	function codistan_approved_contributions(){
		echo "<h1 align='center'><b>Approved Contributions</b></h1>";
		echo "<hr></br>";

		echo "<table align='center' border='1px' id='codistan_table'>";
		echo "<tr><th>Sr.</th><th>Username</th><th>Title</th><th>Descripton</th><th>Media Type</th><th>Media Link</th><th>Time</th><th>Delete</th></tr>";

		global $wpdb;
		$result = $wpdb->get_results( "SELECT * FROM codistan_contributions WHERE status=true");
		$count = 1;
		foreach($result as $row){
			$link;
			if($row->file_uploaded)
				$link = site_url() . "/" . $row->media_link;
			else
				$link = $row->media_link;

			$result = $wpdb->get_results( "SELECT * FROM codistan_media WHERE id='". $row->media_id . "'");
			$media_info;
			foreach($result as $row1){
				$media_info = $row1;
				break;
			}

			echo "<tr><td>".$count++."</td>
					<td>".get_userdata($row->user_id)->user_login."</td>
					<td><a target='_blank' href='/".media_page_url()."/?id=".$media_info->id."'>".$media_info->title."</td><td>".$row->description."</td>
					<td>".$row->media_type."</td>
					<td><a target='_blank' href='".$link."'>Click Here</a></td>
					<td>".$row->time."</td>
					<td><input type='image' align='center' src='".plugins_url( '/images/delete.png' , __FILE__ )."'  onClick='deleteRecord(". $row->id .",this);'></td>
				</tr>";
		}

		echo "</table>";
	}

	function deleteRecord(){
		global $wpdb;
		$id = $_POST['id'];

		$row_count = $wpdb->get_var( "SELECT COUNT(*) FROM codistan_contributions WHERE id=".$id );
		$result = $wpdb->get_results( "SELECT * FROM codistan_contributions WHERE id=".$id );
		$media_id;
		foreach($result as $row){
			if($row->file_uploaded)
				unlink("../" . $row->media_link);
			$media_id = $row->media_id;
			break;
		}
		error_log("result: " . count($results) . " " . $media_id);
		if($row_count == 1)
			$wpdb->delete( 'codistan_media', array( 'id' => $media_id) );
		$wpdb->delete( 'codistan_contributions', array( 'id' => $id) );

		die();
	}

	function approveRecord(){
		global $wpdb;
		$id = $_POST['id'];

		$wpdb->update( 'codistan_contributions', array( 'status' => true), array( 'id' => $id) );

		$result = $wpdb->get_results( "SELECT * FROM codistan_contributions WHERE id=".$id);
		$media_id;
		foreach($result as $row){
			$media_id = $row->media_id;
			break;
		}
		$wpdb->update( 'codistan_media', array( 'status' => true), array( 'id' => $media_id) );

		die();
	}
?>
