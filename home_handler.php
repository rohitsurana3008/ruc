<?php
//include 'php/setup.php';
include("php".DIRECTORY_SEPARATOR."setup.php");

//$obj = json_decode('{to_call:get_post_data}');
/*
home_info:
{
    "to_call": "put_post_comment_data",
	"post_id": "34",
	"comment" "hahahahahahahahaha"
}

*/

$obj = json_decode($_POST['home_info']);
$to_call = $obj->to_call;

session_start();
$user_id = $_SESSION['user_id'];
//$user_id = 28;

function get_post_data($obj_temp, $user_id_temp){
    $get_posts = ORM::for_table('(Select x.*, y.user_id, y.user_name, y.photo, z.neighbourhood from posts x, users y, user_profile z WHERE
 x.user_id = y.user_id and x.user_id = z.user_id 
ORDER BY updated_at DESC LIMIT 50)')->raw_query('
	Select a.*, b.likes, b.dislikes,c.comments, 
	(Select reaction from post_reactions where a.post_id = post_id and user_id = :userid) as user_reaction 
	from (Select x.*, y.user_name,y.photo, z.neighbourhood from posts x, users y, user_profile z WHERE
 x.user_id = y.user_id and x.user_id = z.user_id 
ORDER BY updated_at DESC LIMIT 50) a LEFT JOIN post_reactions_aggr b ON
	a.post_id = b.post_id 
	LEFT OUTER JOIN comments_aggr c ON
	a.post_id = c.post_id', array('userid' => $user_id_temp))->find_many();
    
	$obj_to_send = new \stdClass();
	$myArr = array();
    $counter = 0;
	
    foreach ($get_posts as $post_info) {
		$post_to_send = new \stdClass();
		$post_to_send->user_id = $post_info->user_id;
		$post_to_send->user_name = $post_info->user_name;
		$post_to_send->neighbourhood = $post_info->neighbourhood;
		$post_to_send->photo = $post_info->photo;
		$post_to_send->post_id = $post_info->post_id;
		$post_to_send->desc_text = $post_info->desc_text;
		$post_to_send->file_type = $post_info->file_type;
		$post_to_send->resource_url = $post_info->resource_url;
		$post_to_send->likes = $post_info->likes;
		$post_to_send->dislikes = $post_info->dislikes;
		$post_to_send->user_reaction = $post_info->user_reaction;
		$post_to_send->comments = $post_info->comments;
		
        $myArr[$counter++] = $post_to_send;
    }
            
    $obj_to_send->posts = $myArr;
    $myJSON = json_encode($obj_to_send);
    echo $myJSON;	      
}

function get_post_comment_data($obj_temp, $user_id_temp){
    $post_info = ORM::for_table('(Select x.*, y.user_name, y.photo, z.neighbourhood from posts x, users y, user_profile z WHERE
 x.user_id = y.user_id and x.user_id = z.user_id and x.post_id= :postid)')->raw_query('
	Select a.*, b.likes, b.dislikes,c.comments, 
	(Select reaction from post_reactions where a.post_id = post_id and user_id = :userid) as user_reaction 
	from (Select x.*, y.user_name,y.photo, z.neighbourhood from posts x, users y, user_profile z WHERE
 x.user_id = y.user_id and x.user_id = z.user_id and x.post_id= :postid) a LEFT JOIN post_reactions_aggr b ON
	a.post_id = b.post_id 
	LEFT OUTER JOIN comments_aggr c ON
	a.post_id = c.post_id', array('userid' => $user_id_temp,'postid' => $obj_temp->post_id))->find_one();
    
	$obj_to_send = new \stdClass();
	$myArr = array();
    $counter = 0;
	
    if ($post_info) {
		
		$obj_to_send->post_id = $post_info->post_id;
		$obj_to_send->user_name = $post_info->user_name;
		$obj_to_send->neighbourhood = $post_info->neighbourhood;
		$obj_to_send->photo = $post_info->photo;
		$obj_to_send->desc_text = $post_info->desc_text;
		$obj_to_send->file_type = $post_info->file_type;
		$obj_to_send->resource_url = $post_info->resource_url;
		$obj_to_send->likes = $post_info->likes;
		$obj_to_send->dislikes = $post_info->dislikes;
		$obj_to_send->user_reaction = $post_info->user_reaction;
		$obj_to_send->comments = $post_info->comments;
		
		$post_comment_info = ORM::for_table('comments')->raw_query('SELECT a.post_id, a.comment, b.user_name, b.photo FROM comments a, users b WHERE a.post_id = :postid and a.user_id = b.user_id', array('postid' => $obj_temp->post_id))->find_many();
		
		$myArr = array();
		$counter = 0;
		foreach ($post_comment_info as $post_info_temp) {
			$post_to_send = new \stdClass();
			$post_to_send->comment_desc = $post_info_temp->comment;
			$post_to_send->comment_user_name = $post_info_temp->user_name;
			$post_to_send->comment_user_photo = $post_info_temp->photo;
			
			$myArr[$counter++] = $post_to_send;
		}
		
		$obj_to_send->comments_data = $myArr;
    }
            
    $myJSON = json_encode($obj_to_send);
    echo $myJSON;	
}


function put_post_comment_data($obj_temp, $user_id_temp, $host_t, $user_t, $pass_t, $database_t){
	$add_comment = ORM::for_table('comments')->create();
	$add_comment->user_id = $user_id_temp;
	$add_comment->post_id = $obj_temp->post_id;
	$add_comment->comment = $obj_temp->comment;
	$add_comment->save();
	
	$date = date('Y-m-d H:i:s');
	
	// Create connection
	$conn = new mysqli($host_t, $user_t, $pass_t, $database_t);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "UPDATE posts SET updated_at='$date' WHERE post_id = '$obj_temp->post_id'";

	$obj_to_send = new \stdClass();
	if ($conn->query($sql) === TRUE) {
		$obj_to_send->output = "success";
	} else {
		$obj_to_send->output = "unsuccess";
	}
	$myJSON = json_encode($obj_to_send);
	$conn->close(); 
	echo $myJSON;
}


function put_post_reaction_data($obj_temp, $user_id_temp, $host_t, $user_t, $pass_t, $database_t){
	$update_reaction = ORM::for_table('post_reactions')->where_raw('(user_id = ? and post_id = ?)', array($user_id_temp, $obj_temp->post_id))->find_one();
	$conn = new mysqli($host_t, $user_t, $pass_t, $database_t);
	if($update_reaction)
	{
		if($update_reaction->reaction == $obj_temp->reaction)
		{
			$sql = "DELETE FROM post_reactions WHERE user_id = $user_id_temp and post_id = $obj_temp->post_id";
			$conn->query($sql);
		}
		else
		{
			$update_reaction->reaction = $obj_temp->reaction;
		}
		$update_reaction->save();
	}
	else
	{
		$update_reaction = ORM::for_table('post_reactions')->create();
		$update_reaction->user_id = $user_id_temp;
		$update_reaction->post_id = $obj_temp->post_id;
		$update_reaction->reaction = $obj_temp->reaction;
		$update_reaction->save();
	}
	$obj_to_send = new \stdClass();
	$get_aggregate_query = ORM::for_table('post_reactions_aggr')->where('post_id', $obj_temp->post_id)->find_one();
	
	$obj_to_send->likes = $get_aggregate_query->likes;
	$obj_to_send->dislikes = $get_aggregate_query->dislikes;
	
	$myJSON = json_encode($obj_to_send);
	$conn->close(); 
	echo $myJSON;
}

switch ($to_call) {
    case "get_post_data":
        get_post_data($obj, $user_id);
    break;
	case "get_post_comment_data":
        get_post_comment_data($obj, $user_id);
    break;
	case "put_post_comment_data":
        put_post_comment_data($obj, $user_id, $host, $user, $pass, $database);
    break;
	case "put_post_reaction_data":
        put_post_reaction_data($obj, $user_id, $host, $user, $pass, $database);
    break;
    default:
        echo 'no method';
}

?>