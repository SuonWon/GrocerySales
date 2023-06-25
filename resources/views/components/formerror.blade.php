@props(['name'])

@error($name)
     <p class="text-danger col-12" style="color:red;">{{$message}}</p> 
@enderror