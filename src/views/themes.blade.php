@extends('../dashboard')
@section('body-header')
	<h1 class="dashboard__title">Themes</h1>
@stop
@section('body-content')

	@if ($messages)
		<div class="node__y--bottom">
			@if ($messages->has('success'))
				<div class="message_box message_box--wasabi">
					<span class="message_box__title">Woot!</span>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div>
			@else
				<div class="message_box message_box--tomato">
					<span class="message_box__title">Great Scott!</span>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div> 
			@endif
		</div>
	@endif

	{{ Form::open() }}
		<div class="well">
			<div class="control_block">
				{{ Form::label('theme', 'Application theme', array('class' => 'label label--block')) }}
				{{ Form::select('theme', $themes, $theme_setting->value(), array('class' => 'select')) }}
			</div>
		</div>
		<div class="form__controls form__controls--standard control_block">
			<div class="form__controls__left">
				<a href="{{ URL::route('admin.dashboard') }}" class="button button--mustard">Back</a>
			</div>
			<div class="form__controls__right align--right">
				{{ Form::submit('Save theme settings', array('class' => 'button button--wasabi')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop