<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Menu_det;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
        $user=Auth::user();
        if($user->admin == 1 ||  $user->admin == 2){
            $menu= Menu::orderBy('created_at','desc')->paginate(4);
            return view('menu.index', ['menu'=>$menu]);
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

        $user=Auth::user();
        if($user->admin == 1 ||  $user->admin == 2){
            $menu= Menu::all();
            $product= Product::orderBy('category_id', 'desc')->get();
            return view('menu.create', ['menu'=>$menu, 'product'=>$product]);
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
        $product_m=$request->get("product_m");
        $product_t=$request->get("product_t");
        $product_w=$request->get("product_w");
        $product_th=$request->get("product_th");
        $product_f=$request->get("product_f");
        $product_s=$request->get("product_s");
        $product_su=$request->get("product_su");

        $menu= new Menu();
        $menu_det= new Menu_det();
        $menu->name= $request->get('name');
        $menu->date_begin= date("Y-m-d", strtotime(strtr($request->get('date_begin'),'/','-')));
        $menu->date_end= date("Y-m-d", strtotime(strtr($request->get('date_end'),'/','-')));
        $menu->status=1;
        $menu->save();
        $i=0;
        foreach($product_m as $pro){
           Menu_det::create([
                'menu_id'=>$menu->id,
                'product_id'=>$pro,
                'day'=>0,
                'numero'=>$i,
           ]);
           $i++;
        }
        $i=0;
        foreach($product_t as $pro){
            Menu_det::create([
                 'menu_id'=>$menu->id,
                 'product_id'=>$pro,
                 'day'=>1,
                 'numero'=>$i,
            ]);
            $i++;
         }
         $i=0;
         foreach($product_w as $pro){
            Menu_det::create([
                 'menu_id'=>$menu->id,
                 'product_id'=>$pro,
                 'day'=>2,
                 'numero'=>$i,
            ]);
            $i++;
         }
         $i=0;
         foreach($product_th as $pro){
            Menu_det::create([
                 'menu_id'=>$menu->id,
                 'product_id'=>$pro,
                 'day'=>3,
                 'numero'=>$i,
            ]);
            $i++;
         }
         $i=0;
         foreach($product_f as $pro){
            Menu_det::create([
                 'menu_id'=>$menu->id,
                 'product_id'=>$pro,
                 'day'=>4,
                 'numero'=>$i,
            ]);
            $i++;
         }
         $i=0;
         foreach($product_s as $pro){
            Menu_det::create([
                 'menu_id'=>$menu->id,
                 'product_id'=>$pro,
                 'day'=>5,
                 'numero'=>$i,
            ]);
            $i++;
         }

         $i=0;
         foreach($product_su as $pro){
            Menu_det::create([
                 'menu_id'=>$menu->id,
                 'product_id'=>$pro,
                 'day'=>6,
                 'numero'=>$i,
            ]);
            $i++;
         }

         return redirect('/menu')->with('notice', 'El Menú fue creado con exito, recuerde asignar los precios de cada plato.');
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
        $user=Auth::user();
        if($user->admin == 1 ||  $user->admin == 2){
            $menu = Menu::findOrfail($id);
            $product= Product::orderBy('category_id', 'desc')->get();
            $menu_det_m0= Menu_det::where('menu_id', $id)->where('day', 0)->where('numero', 0)->first();
            $menu_det_m1= Menu_det::where('menu_id', $id)->where('day', 0)->where('numero', 1)->first();
            $menu_det_m2= Menu_det::where('menu_id', $id)->where('day', 0)->where('numero', 2)->first();

            $menu_det_t0= Menu_det::where('menu_id', $id)->where('day', 1)->where('numero', 0)->first();
            $menu_det_t1= Menu_det::where('menu_id', $id)->where('day', 1)->where('numero', 1)->first();
            $menu_det_t2= Menu_det::where('menu_id', $id)->where('day', 1)->where('numero', 2)->first();


            $menu_det_w0= Menu_det::where('menu_id', $id)->where('day', 2)->where('numero', 0)->first();
            $menu_det_w1= Menu_det::where('menu_id', $id)->where('day', 2)->where('numero', 1)->first();
            $menu_det_w2= Menu_det::where('menu_id', $id)->where('day', 2)->where('numero', 2)->first();


            $menu_det_th0= Menu_det::where('menu_id', $id)->where('day', 3)->where('numero', 0)->first();
            $menu_det_th1= Menu_det::where('menu_id', $id)->where('day', 3)->where('numero', 1)->first();
            $menu_det_th2= Menu_det::where('menu_id', $id)->where('day', 3)->where('numero', 2)->first();


            $menu_det_f0= Menu_det::where('menu_id', $id)->where('day', 4)->where('numero', 0)->first();
            $menu_det_f1= Menu_det::where('menu_id', $id)->where('day', 4)->where('numero', 1)->first();
            $menu_det_f2= Menu_det::where('menu_id', $id)->where('day', 4)->where('numero', 2)->first();

            $menu_det_s0= Menu_det::where('menu_id', $id)->where('day', 5)->where('numero', 0)->first();
            $menu_det_s1= Menu_det::where('menu_id', $id)->where('day', 5)->where('numero', 1)->first();
            $menu_det_s2= Menu_det::where('menu_id', $id)->where('day', 5)->where('numero', 2)->first();

            $menu_det_su0= Menu_det::where('menu_id', $id)->where('day', 6)->where('numero', 0)->first();
            $menu_det_su1= Menu_det::where('menu_id', $id)->where('day', 6)->where('numero', 1)->first();
            $menu_det_su2= Menu_det::where('menu_id', $id)->where('day', 6)->where('numero', 2)->first();


            //return $menu_det_t0;
            return view('menu.edit', array('menu'=>$menu, 'product'=>$product,
            'menu_det_m0'=>$menu_det_m0,
            'menu_det_m1'=>$menu_det_m1,
            'menu_det_m2'=>$menu_det_m2,
            'menu_det_t0'=>$menu_det_t0,
            'menu_det_t1'=>$menu_det_t1,
            'menu_det_t2'=>$menu_det_t2,
            'menu_det_w0'=>$menu_det_w0,
            'menu_det_w1'=>$menu_det_w1,
            'menu_det_w2'=>$menu_det_w2,
            'menu_det_th0'=>$menu_det_th0,
            'menu_det_th1'=>$menu_det_th1,
            'menu_det_th2'=>$menu_det_th2,
            'menu_det_f0'=>$menu_det_f0,
            'menu_det_f1'=>$menu_det_f1,
            'menu_det_f2'=>$menu_det_f2,
            'menu_det_s0'=>$menu_det_s0,
            'menu_det_s1'=>$menu_det_s1,
            'menu_det_s2'=>$menu_det_s2,
            'menu_det_su0'=>$menu_det_su0,
            'menu_det_su1'=>$menu_det_su1,
            'menu_det_su2'=>$menu_det_su2,
            ));
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
        $product_m1=$request->get("product_m1");
        $product_m2=$request->get("product_m2");
        $product_m3=$request->get("product_m3");

        $product_t1=$request->get("product_t1");
        $product_t2=$request->get("product_t2");
        $product_t3=$request->get("product_t3");

        $product_w1=$request->get("product_w1");
        $product_w2=$request->get("product_w2");
        $product_w3=$request->get("product_w3");


        $product_th1=$request->get("product_th1");
        $product_th2=$request->get("product_th2");
        $product_th3=$request->get("product_th3");


        $product_f1=$request->get("product_f1");
        $product_f2=$request->get("product_f2");
        $product_f3=$request->get("product_f3");

        $product_s1=$request->get("product_s1");
        $product_s2=$request->get("product_s2");
        $product_s3=$request->get("product_s3");

        $product_su1=$request->get("product_su1");
        $product_su2=$request->get("product_su2");
        $product_su3=$request->get("product_su3");

        $menu= Menu::find($id);
        $menu->name= $request->get('name');
        $menu->date_begin= $request->get('date_begin');
        $menu->date_end= $request->get('date_end');

        if($request->has('status')){
            $menu->status=1;
        }
        else{
            $menu->status=0;
        }
        $menu->save();


        $pm1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 0)->first();
        $pm2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 0)->first();
        $pm3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 0)->first();

        $pt1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 1)->first();
        $pt2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 1)->first();
        $pt3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 1)->first();


        $pw1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 2)->first();
        $pw2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 2)->first();
        $pw3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 2)->first();


        $pth1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 3)->first();
        $pth2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 3)->first();
        $pth3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 3)->first();

        $pf1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 4)->first();
        $pf2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 4)->first();
        $pf3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 4)->first();

        $ps1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 5)->first();
        $ps2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 5)->first();
        $ps3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 5)->first();

        $psu1=Menu_det::where('menu_id', $menu->id)->where('numero', 0)->where('day', 6)->first();
        $psu2=Menu_det::where('menu_id', $menu->id)->where('numero', 1)->where('day', 6)->first();
        $psu3=Menu_det::where('menu_id', $menu->id)->where('numero', 2)->where('day', 6)->first();



        foreach($product_m1 as $p1){
            $pm1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_m2 as $p2){
            $pm2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_m3 as $p3){
            $pm3->update([
                'product_id'=>$p3
            ]);
        }

        foreach($product_t1 as $p1){
            $pt1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_t2 as $p2){
            $pt2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_t3 as $p3){
            $pt3->update([
                'product_id'=>$p3
            ]);
        }

        foreach($product_w1 as $p1){
            $pw1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_w2 as $p2){
            $pw2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_w3 as $p3){
            $pw3->update([
                'product_id'=>$p3
            ]);
        }

        foreach($product_th1 as $p1){
            $pth1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_th2 as $p2){
            $pth2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_th3 as $p3){
            $pth3->update([
                'product_id'=>$p3
            ]);
        }

        foreach($product_f1 as $p1){
            $pf1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_f2 as $p2){
            $pf2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_f3 as $p3){
            $pf3->update([
                'product_id'=>$p3
            ]);
        }


        foreach($product_s1 as $p1){
            $ps1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_s2 as $p2){
            $ps2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_s3 as $p3){
            $ps3->update([
                'product_id'=>$p3
            ]);

            foreach($product_t1 as $p1){
            $pt1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_t2 as $p2){
            $pt2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_t3 as $p3){
            $pt3->update([
                'product_id'=>$p3
            ]);
        }

        }

        foreach($product_su1 as $p1){
            $psu1->update([
                'product_id'=>$p1
            ]);
        }
        foreach($product_su2 as $p2){
            $psu2->update([
                'product_id'=>$p2
            ]);
        }

        foreach($product_su3 as $p3){
            $psu3->update([
                'product_id'=>$p3
            ]);
        }

        return redirect('/menu')->with('notice', 'El Menú ha sido actualizado.');


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

    public function assign_price($id)
    {
        $user=Auth::user();
        if($user->admin == 1 ||  $user->admin == 2){
            $menu = Menu::findOrfail($id);
            $menu_det= Menu_det::select('menu_det.id','product.name','menu_det.price', 'menu_det.day','days.name as dayname')->
            join('product','product.id','=','menu_det.product_id')->
            join('days','days.id','=','menu_det.day')->
            where('menu_id', $menu->id)->get();

            //dd($menu_det);
            return view('menu.assign', ['menu'=>$menu, 'menu_det'=>$menu_det] );
        }
        else{
            return abort(404);
        }
    }

    public function assign_update(Request $request, $id){

        $user=Auth::user();
        if($user->admin == 1 ||  $user->admin == 2){
            $menu = Menu::findOrfail($id);
            if($request->get('pid_m')!=null){

                $idm=$request->get('pid_m');
                $pm=$request->get('price_m');
                $i=0;
                foreach($idm as $p){
                    $pm1=Menu_det::where('id', $p)->first();
                    $pm1->update([
                        'price'=>$pm[$i]
                    ]);
                    $i++;
                }
            }

            if($request->get('pid_t')!=null){
                $idt=$request->get('pid_t');
                $pt=$request->get('price_t');
                $i=0;
                foreach($idt as $p){
                    $pt1=Menu_det::where('id', $p)->first();
                    $pt1->update([
                        'price'=>$pt[$i]
                    ]);
                    $i++;
                }
            }


            if($request->get('pid_w')!=null){
                $idw=$request->get('pid_w');
                $pw=$request->get('price_w');
                $i=0;
                foreach($idw as $p){
                    $pw1=Menu_det::where('id', $p)->first();
                    $pw1->update([
                        'price'=>$pw[$i]
                    ]);
                    $i++;
                }
            }

            if($request->get('pid_th')!=null){
                $idth=$request->get('pid_th');
                $pth=$request->get('price_th');
                $i=0;
                foreach($idth as $p){
                    $pth1=Menu_det::where('id', $p)->first();
                    $pth1->update([
                        'price'=>$pth[$i]
                    ]);
                    $i++;
                }
            }
            if($request->get('pid_f')!=null){
                $idf=$request->get('pid_f');
                $pf=$request->get('price_f');
                $i=0;
                foreach($idf as $p){
                    $pf1=Menu_det::where('id', $p)->first();
                    $pf1->update([
                        'price'=>$pf[$i]
                    ]);
                    $i++;
                }
            }
            if($request->get('pid_s')!=null){
                $ids=$request->get('pid_s');
                $ps=$request->get('price_s');
                $i=0;
                foreach($ids as $p){
                    $ps1=Menu_det::where('id', $p)->first();
                    $ps1->update([
                        'price'=>$ps[$i]
                    ]);
                    $i++;
                }
            }

            if($request->get('pid_su')!=null){
                $idsu=$request->get('pid_su');
                $psu=$request->get('price_su');
                $i=0;
                foreach($idsu as $p){
                    $psu1=Menu_det::where('id', $p)->first();
                    $psu1->update([
                        'price'=>$psu[$i]
                    ]);
                    $i++;
                }
            }
            return redirect('/menu')->with('notice', 'Los precios se han guardado con Éxito.');
        }
        else{
            return abort(404);
        }

    }
}
