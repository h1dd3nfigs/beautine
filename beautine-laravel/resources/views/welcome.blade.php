@extends('layouts.default')
@section('content')

	<div class="how-it-works">
		<p>STEP 1:	Search for your guru by YouTube username</p>
		<p>STEP 2: 	Read a list of your blogger's staples</p>
		<p>STEP 3: 	Save the list to your feed to remember what to try next</p>
		<br />

		{!! Form::open(['route'=>'bloggers.store'])	!!}
	
		{!! Form::input('text', 'blogger_username', null, [
													'class'=>'form-input',
													'placeholder' => 'Paste blogger\'s username here', 
													'size'=>'60']) 
			!!}
		
		{!! Form::submit('SEARCH',['class'=>'form-button'])	!!}<br />
		{!! Form::close() !!}
		
		@if(isset($_POST['blogger_username']))

			<p>Blogger Name: {{ $channel_summary['blogger_username'] }}</p>
			<p>Number of Subscribers: {{  $channel_summary['subscriber_count'] }}</p>
			<img src="{{ $channel_summary['blogger_pic'] }}"><br /><br />

			{!!	Form::open(['route'=>'bloggers.store']) !!}
			{!!	Form::hidden('blogger_username2', $channel_summary['blogger_username']) !!}
			{!!	Form::hidden('uploads_list_id', $channel_summary['uploads_list_id']) !!}
			{!!	Form::submit('Get Blogger\'s Uploaded Videos',['class'=> 'form-button'])	!!}
		
		
			{!!	Form::close()!!}

		@endif

	</div>

@stop