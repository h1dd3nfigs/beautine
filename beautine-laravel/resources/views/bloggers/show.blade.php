@extends('layouts.default')
@section('content')

	<div class="product-list">

		@foreach($filtered_uploaded_vids as $vid)
			<p>{{ $vid['vid_title'] }} ({{ $vid['vid_date'] }}) </p>
			<img src="{{ $vid['vid_img_url'] }}">
			<ol>
				@foreach($vid['vid_products'] as $product)
					<li>{{ $product }}</li>
				@endforeach
			</ol>
		@endforeach
	</div>

@stop