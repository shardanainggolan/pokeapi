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
		<div class="col-12">
			<h1>My Pokemon List</h1>
			<ul class="list-group" id="myList">

			</ul>
		</div>
	</div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
	<div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
		<div class="toast-header">
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			Berhasil release pokemon
		</div>
	</div>
</div>

<script>

	(function() {
		var successToast = document.getElementById('successToast')

		var pokeList = localStorage.getItem('pokeLists');

		// console.log(pokeList);

		// return

		if(pokeList != undefined) {
			pokeList = JSON.parse(pokeList);

			// console.log(pokeList)

			var html = ''
			pokeList.map((v, i) => {
				// console.log(v);
				
				fetch(`https://pokeapi.co/api/v2/pokemon/${v}`)
					.then(response => response.json())
					.then(data => {
						console.log(data.length)
						
						html += `
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<img src="${data.sprites.other.dream_world.front_default}" style="width: 50px;" />
								${ucWords(data.name)}
								<button type="button" class="btn btn-danger btn-sm rounded-lg" onclick="releasePoke(${v})" class="release" id="${v}">
									Release
								</button>
							</li>
						`
						// console.log(html)
						var pokeList = document.getElementById('myList')
						pokeList.innerHTML = html
					});
			})
		}

		function ucWords(text) {
			return text.split(' ').map((txt) => (txt.substring(0, 1).toUpperCase() + txt.substring(1, txt.length))).join(' ');
		}
	})();

	
	function releasePoke(id) {
		console.log(id)

		var pokeList = localStorage.getItem('pokeLists');
		if(pokeList != undefined) {
			pokeList = JSON.parse(pokeList);

			if(isInArray(id, pokeList)) {
				var toast = new bootstrap.Toast(successToast)

    			toast.show()
			}

			// pokeList.push(id)
			var filteredAry = pokeList.filter(function(e) { return e !== id })

			localStorage.setItem('pokeLists', JSON.stringify(filteredAry))

			successToast.addEventListener('hidden.bs.toast', function () {
				return location.href = '{{ route("list") }}'
			})
		}
	}

	function isInArray(value, array) {
		return array.indexOf(value) > -1;
	}

</script>

@endsection