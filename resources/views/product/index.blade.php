@extends('layouts.menu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card">
                <div class="card-body">
                <div class="text_lans_h3">{{ __('Platos') }}</div>
                    <div class="form-group">
                        <div class="col">
                        <a class="btn btn-primary" href="../product/create">Crear</a>
                        @if(Session::has('notice'))
                        <div class="row justify-content-center"> <div class="alert alert-success col-sm-5 text-center"><strong> {{ Session::get('notice') }} </strong></div></div>
                         @endif
                    </div>
                 </div>
                   <div class="table-responsive">
                    <table class="table table-hover display">
                    <tr>
                        <th width=50px>#</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Imágen</th>
                        <th>Estado</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                     @php($i=1)
                     @foreach($product as $pro)
                       <tr>
                        <td><?php echo $i; ?></td>
                        <td>{{$pro->name}}</td>
                        <td>{{$pro->catename}}</td>

                        <td>@if($pro->filename!=null)<img src="{{ route('image.s',['id'=>$pro->id]) }}" width="100" height="60"/> @endif</td>

                        @if(($pro->status)==0)
                         <td>Inactivo<td>
                        @else
                         <td>Activo</td>
                         <td>&nbsp;</td>
                       @endif
                       <td><a class="btn btn-primary" href="product/{{$pro->id}}/edit">Modificar</a></td>
                       </tr>
                       @php($i++)
                     @endforeach
                     </table>
                     <div>{!! $product->links() !!}</div>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

