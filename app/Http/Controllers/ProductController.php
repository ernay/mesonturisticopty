<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use File;
use Image;
use Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin=Auth::user()->admin;
        if($admin==1 || $admin==2){

            $product=Product::select('product.id', 'product.name', 'product.status','category.name as catename', 'product.filename')->
            leftjoin('category','product.category_id','=','category.id')->
            orderBy('name','asc')->
            paginate(6);
            return view('product.index',['product'=>$product ]);
        }
        else{
             return abort(404);
         }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $admin=Auth::user()->admin;
        if($admin==1 || $admin==2){

            $product= Category::all();
            return view('product.create', ['product' => $product]);
        }
        else{
             return abort(404);
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData = $request->validate(['category_id' => 'required|integer|not_in:0', 'filename' => 'image|mimes:jpeg,png,jpg,gif,svg']);

        $pro= new Product();
        $pro->name = $request->get('name');
        $pro->category_id = $request->get('category_id');
        $pro->price=$request->get('price');
        $pro->status = 1;
        $image=$request->file('filename');

        if ($image && $image != null) {
          $image_name = time() . $image->getClientOriginalName();
          Storage::disk('meson')->put($image_name, File::get($image));
          $pro->filename = $image_name;
        }
        $pro->save();
        return redirect('/product')->with('notice', 'El plato ha sido creado correctamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $admin=Auth::user()->admin;
       if($admin==1 || $admin==2){

            $product = Product::findOrFail($id);
            $category= Category::all();
            return view('product.edit', array('product' => $product, 'category'=> $category));
        }
        else{
             return abort(404);
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validData = $request->validate(['category_id' => 'required|integer|not_in:0']);
        $product= Product::find($id);
        $product->name = $request->get('name');
        $product->category_id = $request->get('category_id');
        $product->price= $request->get('price');
        $image=$request->file('filename');
       // dd($image);
        if ($image && $image != null) {
          $image_name = time() . $image->getClientOriginalName();
          Storage::disk('meson')->put($image_name, File::get($image));
          $product->filename = $image_name;
        }
        if($request->has('status')){
            $product->status=1;
        }
        else{
            $product->status=0;
        }
        $product->save();
        return redirect('/product')->with('notice', 'El plato ha sido actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getImage($id) {
        $product= Product::find($id);
        $filename = $product->filename;
        $file = Storage::disk('meson')->get($filename);
         //dd($file);
        return Response($file);

    }
}
