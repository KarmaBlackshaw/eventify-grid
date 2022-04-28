<?php

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$audit = new Audit;

if(isset($_POST['load_feed'])){
	$student = new Student();
	$layouts = new Layouts();
	$offset = $init->post('offset');

	$profile_picture = $layouts->getProfilePicture();
	$event_sql = $student->getApprovedEvents($offset);

	$str = '';

	foreach($event_sql as $data){
		$create = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at);
		$getReact = $student->getReact($data->event_id);

		$liked = $disliked = 'text-muted';

		if($getReact){
			$liked = 'text-primary';
		} elseif(is_null($getReact)){
			$liked = $disliked = 'text-muted';
		} else{
			$disliked = 'text-danger';
		}

		$event_id = $data->event_id;

		$str .= '<div class="card" id="events_card">';
			$str .= '<div class="card-body pb-1">';
				$str .= '<div class="media " value="yow">';
					$str .= '<img src="/assets/images/ssc/ssc.png" class="avatar avatar-xl 
					align-self-start mr-3" alt="...">';
					$str .= '<div class="media-body">';
						$str .= '<a href="javascript:" class="h5 mb-0 pb-0">'. ucfirst($data->event) .'</a>';
						$str .= '<small class="d-block font-italic font-weight-light mb-2" style="font-size: 0.7rem;">'. $create->diffForHumans() .' | SSC Organization</small>';
						$str .= '<p>'. $data->description .'</p>';

						$str .= '<span class="small d-block reaction_div">';
							$str .= '<div class="avatar-list avatar-list-stacked">';
								$str .= '<img src="'. assets("images/defaults/like.png") .'" alt="" class="avatar hvr-pop avatar-sm mx-2">';
								$str .= '<img src="'. assets("images/defaults/dislike.png") .'" alt="" class="avatar hvr-pop avatar-sm mx-2">';
								$str .= '<span class="avatar mx-2 bg-transparent border-transparent small ml-3 pt-1 react_numerals">'. $student->getNumeralReacts($event_id) .'</span>';
							$str .= '</div>';
						$str .= '</span>';
					$str .= '</div>';
				$str .= '</div>';

				$str .= '<hr class="m-1">';
				$str .= '<div class="btn-group w-100" id="feed_btns">';
					$str .= '<a href="javascript:" data-event_id="'. $event_id .'" class="btn btn-transparent hvr-icon-grow w-100 btn_like"><span class="far fa-thumbs-up fa-lg hvr-icon icon_like mr-3 '. $liked .' "></span> Like </a>';
					$str .= '<a href="javascript:" class="btn btn-transparent hvr-icon-grow w-100"><i class="far fa-comment-alt fa-lg hvr-icon mr-3 text-muted"></i> Comment </a>';
					$str .= '<a href="javascript:" data-event_id="'. $event_id .'" class="btn btn-transparent hvr-icon-grow w-100 btn_dislike"><i class="far fa-thumbs-down fa-lg hvr-icon icon_dislike mr-3 '. $disliked .'"></i> Dislike </a>';
				$str .= '</div>';
			$str .= '</div>';

			$str .= '<div class="card-footer">';
				$str .= '<div class="d-flex justify-content-start mb-2">';
					$str .= '<img src="'. $profile_picture .'" alt="" class="avatar mr-2">';
					$str .= '<textarea rows="1" data-event_id="'. $event_id .'" class="form-control rounded comment_textarea" placeholder="Write a comment..." draggable="false" style="resize: none;"></textarea>';
				$str .= '</div>';
				$str .= '<div class="comment_section" data-event_id="3">';
				foreach($student->load_comments($event_id) as $comment) :
					$str .= '<div class="d-flex justify-content-start mb-2 comment_div">';
						$str .= '<img src="'. $comment->account_img_url .'" alt="" class="avatar mr-2">';
						$str .= '<span class="bg-light p-2 w-100 d-block font-weight-bold">';
							$str .= '<small class="m-0 p-0">'. $comment->name .'</small>';
							$str .= '</br>';
							$str .= $comment->comment;
							$str .= '</br>';
							$str .= '<small class="font-weight-light font-italic font-06 m-0 p-0">'. $comment->numeral .'</small>';
						$str .= '</span>';
					$str .= '</div>';
				endforeach;
				$str .= '</div>';
				$str .= '<div class="col">';
					$str .= '<a href="javascript:" class="small font-italic load_more_comments" data-comment_count="2" data-event_id="'. $event_id .'">View more comments</a>';
					$str .= '<span class="small text-dark font-italic float-right font-weight-light comment_count_div"><span class="comment_count">2</span> of '. $student->getCommentCount($event_id) .'</span>';
				$str .= '</div>';
			$str .= '</div>';
		$str .= '</div>';
	}

	echo json_encode($str);
}

if(isset($_POST['react'])){
	$student = new Student();
	$event_id = $init->post('event_id');
	$react = $init->post('react');

	$sql = $student->react($react, $event_id);

	if($sql){
		if($react == 0){
			$audit->audit("Disliked an event");
		} else{
			$audit->audit("Liked an event");
		}
	}
}

if(isset($_POST['comment'])){
	$student = new Student();
	$layouts = new Layouts();
	$comment = trim($init->post('comment'));
	$event_id = $init->post('event_id');
	$profile = $layouts->getProfilePicture();

	$str = '';

	if(!empty($comment)){
		$sql = $student->comment($comment, $event_id);

		if($sql){
			$audit->audit("Commented on an event");
			$json['profile'] = $profile;
			$json['name'] = $_SESSION['full_name'];
			echo json_encode($json);
		}
	}
}

if(isset($_POST['load_more_comments'])){
	$student = new Student();
	$event_id = $init->post('event_id');
	$offset = $init->post('load_more_comments');

	$sql = $student->load_comments($event_id, $offset);

	echo json_encode($sql);
}