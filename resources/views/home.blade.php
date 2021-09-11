@extends('layouts.index')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-12">
			<a href="{{ route('list') }}" style="color: black; text-decoration: none;">
				My Pokemon <i class="fas fa-arrow-right"></i>
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<h1>List Pokemon</h1>
			<ul class="list-group">
				@foreach($pokeLists as $poke)
					<a href="{{ route('detail', $loop->iteration) }}" class="list-group-item list-group-item-action">
						{{ ucwords($poke->name) }}
					</a>
				@endforeach
			  </ul>
		</div>
	</div>
	
</div>

@endsection