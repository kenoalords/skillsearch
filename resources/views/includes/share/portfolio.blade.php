<h5 class="bold"><i class="fa fa-share-alt"></i> Share</h5>
<ul class="list-inline share-links">
	<li><a href="{{ route('portfolio_share', ['portfolio'=>$portfolio['uid'], 'url'=>$url, 'type'=>'facebook']) }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
	<li><a href="{{ route('portfolio_share', ['portfolio'=>$portfolio['uid'], 'url'=>$url, 'type'=>'twitter']) }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
	<li><a href="{{ route('portfolio_share', ['portfolio'=>$portfolio['uid'], 'url'=>$url, 'type'=>'google']) }}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
</ul>