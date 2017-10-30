<div class="ui horizontal list">
	<div class="item"><a href="{{ route('portfolio_share', ['portfolio'=>$portfolio['uid'], 'url'=>$url, 'type'=>'facebook']) }}" target="_blank"><i class="fa fa-facebook"></i></a></div>
	<div class="item"><a href="{{ route('portfolio_share', ['portfolio'=>$portfolio['uid'], 'url'=>$url, 'type'=>'twitter']) }}" target="_blank"><i class="fa fa-twitter"></i></a></div>
	<div class="item"><a href="{{ route('portfolio_share', ['portfolio'=>$portfolio['uid'], 'url'=>$url, 'type'=>'google']) }}" target="_blank"><i class="fa fa-google-plus"></i></a></div>
</div>