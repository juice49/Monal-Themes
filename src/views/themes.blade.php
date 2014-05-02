@extends('../dashboard')
@section('body-header')
	<h1 class="color--teal">Themes</h1>
@stop
@section('body-content')

	@if ($messages)
		<div class="node__y--top">
			@if ($messages->has('success'))
				<div class="message_box message_box--wasabi">
					<h6>Woot!</h6>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div>
			@else
				<div class="message_box message_box--tomato">
					<h6>Great Scott!</h6>
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
				{{ Form::label('theme', 'Application theme', array('class' => 'label--block')) }}
				<div class="select__default">
					{{ Form::select('theme', $themes, Input::has('theme') ? Input::get('theme') : $theme_setting->value(), array('class' => 'select')) }}
				</div>
			</div>
		</div>
		<div class="form__controls form__controls--standard control_block">
			<div class="form__controls__left">
				<a href="{{ URL::route('admin.dashboard') }}" class="button button--mustard">Back</a>
			</div>
			<div class="form__controls__right align--right">
				{{ Form::submit('Save', array('class' => 'button button--wasabi')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop