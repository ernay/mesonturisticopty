@extends('layouts.menu')


@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                    <div class="card-body">
                    <div class="text_lans_h3">{{ __('Crear Plato') }}</div>
                        <div class="row">
                            <div class="col">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                    </div>
                                @endif
                                    <form action="/product"  enctype="multipart/form-data" method="POST" >
                                    @csrf
                                    <div class="form-group col-sm-6">
                                        <label for="title">Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Escriba un nombre" value="{{ old('name') }}" required autocomplete="name" title="Ingrese Nombre" autofocus>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="title">Categoría</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                                    <option value="">Seleccione Categoría</option>
                                                    @foreach($product as $pro)
                                                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                                    @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="title">Precio</label>
                                        <input type="number" step="0.01" min="1" name="price" id="price" class="form-control" placeholder="Escriba precio" value="{{ old('price') }}" required autocomplete="price">
                                        <h7>Este precio no se refleja en el menú colaboradores</h7>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="file">Imagen:</label>
                                        <label><h7><input  type="file" name="filename">Ingrese imágenes con una resolución menor ó igual a 600x400</h7></label>
                                    </div>
                                    <div class=col>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <a class="btn btn-secondary" href="/product">Regresar</a>
                                        </form>
                                    </div>
                                </div>
                       </div>
                    </div>
                </div>
           </div>
       </div>
   </div>
</div>


@endsection
