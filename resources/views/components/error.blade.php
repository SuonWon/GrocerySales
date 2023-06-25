@props(['name'])

@error($name)
{{-- <p class="text-danger col-12" style="color:red;">{{$message}}</p> --}}
    <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
      {{$message}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@enderror