<?php


function getAvatar($avatar){
	if($avatar){
        return asset($avatar);
    } else {
        return asset('public/default-user.jpg');
    }
}

function formatSkills($skills){
	// dd($skills);
	$count = count($skills);
	if($count > 1){
		$diff = $count - 1;
		return $skills[0]['skill'] . ' + ' . $diff . ' more';
	}
	return $skills[0]['skill'];
}

function getRatings($count){
	$count = floor((int)$count);
    $star = '';
    $r = 5 - $count;

    for($i=0; $i < $count; $i++){
        $star .= '<span class="glyphicon glyphicon-star text-primary"></span>';
    }
    if($r > 0){
        for($i=0; $i < $r; $i++){
            $star .= '<span class="glyphicon glyphicon-star text-muted" style="opacity:.2"></span>';
        }
    }
    return $star;
}


function identity_check($i=false){
    if($i){
        return ' <i class="glyphicon glyphicon-ok-sign text-success"></i>';
    }
}

function verifyStatus($profile)
{
    $status = '';
    if($profile->verified_email){
        $status .= '<span>Email <i class="glyphicon glyphicon-ok-sign text-success"></i></span>';
    } else {
        $status .= '<span>Email <i class="glyphicon glyphicon-remove-sign text-danger"></i></span>';
    }

    if($profile->identity){
        $status .= '<span>Identity <i class="glyphicon glyphicon-ok-sign text-success"></i></span>';
    } else {
        $status .= '<span>Identity <i class="glyphicon glyphicon-remove-sign text-success"></i></span>';
    }

    return '<span class="user-status">'.$status.'</span>';
}

function getFirstImage($files, $thumb=null){
    if($thumb){
        return asset($thumb);
    }
    return asset($files[0]->file);
}

function getAudioImage($thumb=null){
    if($thumb){
        return asset($thumb);
    }
    return asset('public/audio_wave.jpg');
}