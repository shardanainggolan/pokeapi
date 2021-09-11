@extends('layouts.index')

@section('content')

<div class="container">
	<div class="row mb-3">
		<div class="col-12">
			<a href="/" style="color: black; text-decoration: none;">
				<i class="fas fa-arrow-left"></i> 
				<span class="fw-bold ml-5">Kembali</span>
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-3 d-flex align-items-center justify-content-center">
			<img src="{{ $poke->sprites->other->dream_world->front_default }}" class="img-fluid" />
		</div>
		<div class="col-9">
			<h1>{{ ucwords($poke->name) }}</h1>
			<table class="table table-hover">
				<tbody>
					<tr>
						<th style="width: 80px;">Tipe</th>
						<td style="width: 10px;">:</td>
						<td>{{ $type }}</td>
					</tr>
					<tr>
						<th style="width: 80px;">Tinggi</th>
						<td style="width: 10px;">:</td>
						<td>{{ $poke->height }}dm</td>
					</tr>
					<tr>
						<th style="width: 80px;">Berat</th>
						<td style="width: 10px;">:</td>
						<td>{{ $poke->weight }}hg</td>
					</tr>
					<tr>
						<th style="width: 80px;">Kemampuan</th>
						<td style="width: 10px;">:</td>
						<td>
							<ol>
								@foreach($poke->abilities as $ability)
									@if(!$ability->is_hidden)
										<li>{{ ucwords($ability->ability->name) }}</li>
									@else
										<li>{{ ucwords($ability->ability->name) }} (Kemampuan Tersembunyi)</li>
									@endif
								@endforeach
							</ol>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row my-4">
		<div class="col-12">
			<h4 class="fw-bold">Statistik</h4>
			<table class="table table-hover">
				<tbody>
					@foreach($poke->stats as $stat)
					<tr>
						<th style="width: 180px;">{{ ucwords($stat->stat->name) }}</th>
						<td>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{ $stat->base_stat }}%;" aria-valuenow="{{ $stat->base_stat }}" aria-valuemin="0" aria-valuemax="200">
									{{ $stat->base_stat }}
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div class="row my-4">
		<div class="col-12">
			<h4 class="fw-bold">Moves</h4>
			<ul class="list-group">
				@foreach($poke->moves as $move)
				<li class="list-group-item">{{ ucwords($move->move->name) }}</li>
				@endforeach
			</ul>
		</div>
		<div class="col-12 mt-5">
			<div class="d-grid">
				<button type="button" class="btn btn-primary rounded-lg" onclick="catchPokemon({{$poke->id}})">Tangkap</button>
			</div>
		</div>
	</div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
	<div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
		<div class="toast-header">
			<img src="{{ $poke->sprites->other->dream_world->front_default }}" style="width: 50px;" class="rounded me-2" alt="{{ $poke->name }}">
			<strong class="me-auto">{{ ucwords($poke->name) }}</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			Berhasil menangkap {{ ucwords($poke->name) }} :)
		</div>
	</div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
	<div id="existsToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
		<div class="toast-header">
			<img src="{{ $poke->sprites->other->dream_world->front_default }}" style="width: 50px;" class="rounded me-2" alt="{{ $poke->name }}">
			<strong class="me-auto">{{ ucwords($poke->name) }}</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			{{ ucwords($poke->name) }} sudah ada di dalam list!
		</div>
	</div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
	<div id="failedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
		<div class="toast-header">
			<img src="{{ $poke->sprites->other->dream_world->front_default }}" style="width: 50px;" class="rounded me-2" alt="{{ $poke->name }}">
			<strong class="me-auto">{{ ucwords($poke->name) }}</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			Gagal menangkap {{ ucwords($poke->name) }} :(
		</div>
	</div>
</div>

<script>
	var successToast = document.getElementById('successToast')
	var existsToast = document.getElementById('existsToast')
	var failedToast = document.getElementById('failedToast')

	function catchPokemon(id) {
		// console.log(id)

		var pokeList = localStorage.getItem('pokeLists');

		if(pokeList != undefined) {
			if(isInArray(id, pokeList)) {
				var exists = new bootstrap.Toast(existsToast)

				exists.show()

				return
			}
		}
	
		var d = Math.random()
		if(d < 0.5) {
			var toast = new bootstrap.Toast(successToast)

    		toast.show()
			// console.log(pokeList)
			if(pokeList != undefined) {
				console.log(pokeList)
				pokeList = JSON.parse(pokeList);

				pokeList.push(id)

				localStorage.setItem('pokeLists', JSON.stringify(pokeList))
			} else {
				var pokeList = JSON.stringify([id])
				localStorage.setItem('pokeLists', pokeList)
			}

			successToast.addEventListener('hidden.bs.toast', function () {
				return location.href = '{{ route("list") }}'
			})
			
			return
		} else {
			var fail = new bootstrap.Toast(failedToast)

			fail.show()
		}
	}

	function isInArray(value, array) {
		return array.indexOf(value) > -1;
	}
	
</script>

@endsection