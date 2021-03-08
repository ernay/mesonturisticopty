<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Order;
use App\Models\Order_det;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\edoCuentaExports;
use App\Exports\edoCuentaExportsUser;
use App\Exports\edoCuentaExportsOne;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class edoCuentaController extends Controller
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
    public function export($id,$fecha_ini,$fecha_end){
        return Excel::download(new edoCuentaExports($id,$fecha_ini,$fecha_end), 'edoCuenta.xlsx');
        //dd($id);
    }

    public function export_user($user,$company,$fecha_ini,$fecha_end){
        return Excel::download(new edoCuentaExportsUser($user,$company,$fecha_ini,$fecha_end), 'edoCuenta.xlsx');
        //dd($id);
    }

    public function export_one($company,$user,$fecha_ini,$fecha_end){
        return Excel::download(new edoCuentaExportsOne($company,$user,$fecha_ini,$fecha_end), 'edoCuenta.xlsx');
        //dd($id);
    }

    public function index()
    {
        $user=Auth::user();

        if($user->admin == 1 || $user->admin == 2){
            $company=Company::where('status','=',1)->get();
            return view('edocuenta.index', ['company'=>$company]);
        }
        elseif($user->admin == 3){
            $company=Company::where('status','=',1)->
            where('id','=',$user->company_id)->
            get();

            return view('edocuenta.index', ['company'=>$company]);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {   $fecha_ini=date("Y-m-d", strtotime(strtr($request->date_ini,'/','-')));
        $fecha_end=date("Y-m-d", strtotime(strtr($request->date_end,'/','-')));

        if($request->get('code')!=null){
            $rep=Order::select('order.status','order.documentno','order.date_order', 'order.total', 'order.total_c', 'product.name','order_det.quantity','users.name as uname', 'users.last_name', 'users.code')->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('product','product.id','=','order_det.product_id')->
            leftjoin('users','users.id','=','order.user_id')->
            whereBetween('order.date_order',[$fecha_ini.' 00:00:01', $fecha_end.' 23:59:59'])->
            where('users.code','=',$request->get('code'))->
            where('order.status','!=','3')->
            where('users.company_id','=',$request->get('company_id'));

            $rep_m=User::select('users.code','users.name','users.last_name','company.name as cname', 'company.id','users.status')->
            leftjoin('company','company.id','=','users.company_id')->
            where('code','=',$request->get('code'))->
            where('users.company_id','=',$request->get('company_id'))->
            first();

            $rep_t=DB::table('order')->
            select(DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'), DB::raw('sum(order_det.quantity) as quantity'))->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            leftjoin('company','company.id','=','users.company_id')->
            whereBetween('order.date_order',[$fecha_ini.' 00:00:01', $fecha_end.' 23:59:59'])->
            where('order.status','!=','3')->
            where('users.code','=',$request->get('code'))->
            where('users.company_id','=',$request->get('company_id'))->
            first();
            //dd($rep_t);
            $report=$rep->get();

            $date_ini=$fecha_ini;
            $date_end=$fecha_end;
            $compa=0;

            //dd($compa);

            if(count($report)==0){

                return redirect('/edocuenta')->with('notice', 'Consulta sin data para mostrar');
            }
            else{
             return view('edocuenta.show',
                ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t, 'compa'=>$compa, 'saldo'=>0, 'tpagos'=>0,'fname'=>null]);
               /* return $pdf = \PDF::loadView('edocuenta.show', ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t, 'compa'=>$compa])->
                download('edocuenta_'.$rep_m->code.'.pdf'); */
            }
        }
        elseif($request->get('code')==null && $request->get('fname')==null){

            $report=DB::table('order')->
            select('users.code', 'users.name', 'users.last_name','order_det.quantity as quantity','order.documentno','order.date_order','order.total as total','order.total_c as total_c', 'users.status as ustatus','order.status')->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            where('users.company_id','=',$request->get('company_id'))->
            whereBetween('date_order',[$fecha_ini.' 00:00:01', $fecha_end.' 23:59:59'])->
            where('order.status','!=','3')->
            orderBy('users.id','asc')->
            orderBy('order.date_order','asc')->
            get();

            $rep_m=Company::select('id','name as cname')->where('id',$request->get('company_id'))->first();

            $rep_t=DB::table('order')->
            select(DB::raw('sum(order_det.quantity) as quantity'),DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'))->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            whereBetween('date_order',[$fecha_ini.' 00:00:01', $fecha_end.' 23:59:59'])->
            where('order.status','!=','3')->
            where('users.company_id','=',$request->get('company_id'))->
            first();

            $saldo=DB::table('payment')->
            select(DB::raw('sum(payment.monto) as monto'))->
            where('company_id','=',$request->get('company_id'))->
            whereBetween('date',[$fecha_ini, $fecha_end])->
            first();

            $montos=$saldo->monto;
            $saldo=$rep_t->total-$montos;

            if($montos==null)
                $montos=0;

            $date_ini=$fecha_ini;
            $date_end=$fecha_end;
            $compa=1;
            //dd($rep_t);
            if(count($report)==0){

                return redirect('/edocuenta')->with('notice', 'Consulta sin data para mostrar');
            }
            else{
                return view('edocuenta.show',
                ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t, 'compa'=>$compa, 'saldo'=>$saldo, 'tpagos'=>$montos,'fname'=>null]);
                /*return $pdf = \PDF::loadView('edocuenta.show', ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t,'compa'=>$compa])->
                download('edocuenta_'.$rep_m->cname.'.pdf');*/
            }
        }

        if($request->get('fname')!=null){

            $report=DB::table('order')->
            select('users.code', 'users.name', 'users.last_name','order_det.quantity as quantity','order.documentno','order.date_order','order.total as total','order.total_c as total_c', 'users.status as ustatus','order.status')->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            where('users.company_id','=',$request->get('company_id'))->
            where('users.name','LIKE','%'.$request->get('fname').'%')->
            whereBetween('date_order',[$fecha_ini.' 00:00:01', $fecha_end.' 23:59:59'])->
            where('order.status','!=','3')->
            orderBy('users.id','asc')->
            orderBy('order.date_order','asc')->
            get();

            $rep_m=Company::select('id','name as cname')->where('id',$request->get('company_id'))->first();


            $rep_t=DB::table('order')->
            select(DB::raw('sum(order_det.quantity) as quantity'),DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'))->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            whereBetween('date_order',[$fecha_ini.' 00:00:01', $fecha_end.' 23:59:59'])->
            where('users.name','LIKE','%'.$request->get('fname').'%')->
            where('order.status','!=','3')->
            where('users.company_id','=',$request->get('company_id'))->
            first();

            $saldo=DB::table('payment')->
            select(DB::raw('sum(payment.monto) as monto'))->
            where('company_id','=',$request->get('company_id'))->
            whereBetween('date',[$fecha_ini, $fecha_end])->
            first();

            //dd($report);
            $montos=$saldo->monto;
            $saldo=$rep_t->total-$montos;

            if($montos==null)
                $montos=0;

            $date_ini=$fecha_ini;
            $date_end=$fecha_end;
            $compa=1;
            $fname=$request->get('fname');
            //dd($rep_t);
            if(count($report)==0){

                return redirect('/edocuenta')->with('notice', 'Consulta sin data para mostrar');
            }
            else{
                return view('edocuenta.show',
                ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t, 'compa'=>$compa, 'saldo'=>0, 'tpagos'=>0, 'fname'=>$fname]);
                /*return $pdf = \PDF::loadView('edocuenta.show', ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t,'compa'=>$compa])->
                download('edocuenta_'.$rep_m->cname.'.pdf');*/
            }
        }
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
        //
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
        $user=Auth::user()->id;
        $order=$request->get('order');
       /* $consulta= Order::select('order.id','order.documentno','product.name', 'order.created_at', 'order_det.quantity', 'order.total', 'order.total_c')->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('product','product.id','=','order_det.product_id')->
        where('order.user_id','=',$user)->
        where('order.menu_id','=',$id)->get();*/

        foreach($order as $con){
            $ord=Order::find($con);
            $ord->update([
                'status'=>2
            ]);
        }
        return redirect('/list_edocuenta')->with('notice', 'Estado de cuenta confirmado');
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

    public function list_edoCuenta(){
        $user=Auth::user()->id;

        $report = Order::select('order.menu_id','menu.date_begin', 'menu.date_end', 'order.status', DB::raw('sum(order_det.quantity) as quantity'), DB::raw('sum(order.total) as total'), DB::raw('sum(order.total_c) as total_c'))->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('menu','order.menu_id','=','menu.id')->
        leftjoin('users','users.id','=','order.user_id')->
        where('order.user_id','=',$user)->
        where('order.status','!=',3)->
        groupBy('menu.date_begin', 'menu.date_end', 'order.status', 'order.menu_id')->
        orderBy('menu.date_end','desc')->
        paginate(8);
        $code=Auth::user()->code;
        return view('edocuenta.list_edocuenta',['report'=>$report, 'code'=>$code]);
    }

    public function confirmOrder($id){
        $user=Auth::user()->id;
        $menu=$id;
        $consulta= Order::select('order.id','order.documentno','product.name', 'order.date_order', 'order_det.quantity', 'order.total', 'order.total_c','order.status')->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('product','product.id','=','order_det.product_id')->
        where('order.user_id','=',$user)->
        where('order.status','!=',3)->
        where('order.menu_id','=',$id)->get();

            $con_t=DB::table('order')->
            select(DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'), DB::raw('sum(order_det.quantity) as quantity'))->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            where('order.user_id','=',$user)->
            where('order.status','!=',3)->
            where('order.menu_id','=',$id)->first();


        return view('edocuenta.confirmedo',['consulta'=>$consulta, 'con_t'=>$con_t, 'menu'=>$menu]);
    }

    public function print_edo(Request $request)
    {

        if($request->get('code')==null && $request->get('fname')==null){
            $report=DB::table('order')->
            select('users.code', 'users.name', 'users.last_name','order_det.quantity as quantity','order.documentno','order.date_order','order.total as total','order.total_c as total_c', 'users.status as ustatus','order.status')->
            leftjoin('order_det','order_det.order_id','=','order.id')->
            leftjoin('users','users.id','=','order.user_id')->
            where('users.company_id','=',$request->get('company_id'))->
            whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
            where('order.status','!=','3')->
            orderBy('users.id','asc')->
            orderBy('order.date_order','asc')->
            get();

        $rep_m=Company::select('id','name as cname')->where('id',$request->get('company_id'))->first();

        $rep_t=DB::table('order')->
        select(DB::raw('sum(order_det.quantity) as quantity'),DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'))->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('users','users.id','=','order.user_id')->
        whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
        where('users.company_id','=',$request->get('company_id'))->
        where('order.status','!=','3')->
        first();

        $saldo=DB::table('payment')->
        select(DB::raw('sum(payment.monto) as monto'))->
        where('company_id','=',$request->get('company_id'))->
        whereBetween('date',[$request->date_ini, $request->date_end])->
        first();

        //dd($saldo->monto);
        $montos=$saldo->monto;
        $saldo=$rep_t->total-$montos;

        $date_ini=$request->date_ini;
        $date_end=$request->date_end;
        $compa=1;
        $fname=null;

        return $pdf = \PDF::loadView('edocuenta.print', ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t,'compa'=>$compa, 'saldo'=>$saldo, 'tpagos'=>$montos, 'fname'=>$fname])->
        download('edocuenta_'.$rep_m->cname.'.pdf');
      }
      if($request->get('code')!=null){

        $rep=Order::select('order.status','order.documentno','order.date_order', 'order.total', 'order.total_c', 'product.name','order_det.quantity','users.name as uname', 'users.last_name', 'users.code')->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('product','product.id','=','order_det.product_id')->
        leftjoin('users','users.id','=','order.user_id')->
        whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
        where('users.code','=',$request->get('code'))->
        where('order.status','!=','3')->
        where('users.company_id','=',$request->get('company_id'));

        $rep_m=User::select('users.code','users.name','users.last_name','company.name as cname')->
        leftjoin('company','company.id','=','users.company_id')->
        where('code','=',$request->get('code'))->
        where('users.company_id','=',$request->get('company_id'))->
        first();

        $rep_t=DB::table('order')->
        select(DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'), DB::raw('sum(order_det.quantity) as quantity'))->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('users','users.id','=','order.user_id')->
        leftjoin('company','company.id','=','users.company_id')->
        whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
        where('users.code','=',$request->get('code'))->
        where('order.status','!=','3')->
        where('users.company_id','=',$request->get('company_id'))->
        first();

        $report=$rep->get();

        $date_ini=$request->date_ini;
        $date_end=$request->date_end;
        $compa=0;
        $fname=null;

        return $pdf = \PDF::loadView('edocuenta.print', ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t, 'compa'=>$compa, 'fname'=>$fname])->
        download('edocuenta_'.$rep_m->code.'.pdf');


      }

      if($request->get('fname')!=null){
        /*
        $report=DB::table('order')->
        select('users.status as ustatus','order.status','users.code', 'users.name', 'users.last_name',DB::raw('sum(order_det.quantity) as quantity'),DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'))->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('users','users.id','=','order.user_id')->
        where('users.company_id','=',$request->get('company_id'))->
        where('users.name','LIKE','%'.$request->get('fname').'%')->
        whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
        where('order.status','!=','3')->
        groupBy('users.code', 'users.name', 'users.last_name','order.status','users.status')->
        get();*/

        $report=DB::table('order')->
        select('users.code', 'users.name', 'users.last_name','order_det.quantity as quantity','order.documentno','order.date_order','order.total as total','order.total_c as total_c', 'users.status as ustatus','order.status')->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('users','users.id','=','order.user_id')->
        where('users.company_id','=',$request->get('company_id'))->
        where('users.name','LIKE','%'.$request->get('fname').'%')->
        whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
        where('order.status','!=','3')->
        orderBy('users.id','asc')->
        orderBy('order.date_order','asc')->
        get();

        //dd($report);
        $rep_m=Company::select('id','name as cname')->where('id',$request->get('company_id'))->first();

        $rep_t=DB::table('order')->
        select(DB::raw('sum(order_det.quantity) as quantity'),DB::raw('sum(order.total) as total'),DB::raw('sum(order.total_c) as total_c'))->
        leftjoin('order_det','order_det.order_id','=','order.id')->
        leftjoin('users','users.id','=','order.user_id')->
        whereBetween('date_order',[$request->date_ini.' 00:00:01',$request->date_end.' 23:59:59'])->
        where('users.company_id','=',$request->get('company_id'))->
        where('order.status','!=','3')->
        where('users.name','LIKE','%'.$request->get('fname').'%')->
        first();

        $saldo=DB::table('payment')->
        select(DB::raw('sum(payment.monto) as monto'))->
        where('company_id','=',$request->get('company_id'))->
        whereBetween('date',[$request->date_ini, $request->date_end])->
        first();

        //dd($saldo->monto);
        $montos=$saldo->monto;
        $saldo=$rep_t->total-$montos;

        $date_ini=$request->date_ini;
        $date_end=$request->date_end;
        $fname=$request->get('fname');
        $compa=1;
        return $pdf = \PDF::loadView('edocuenta.print', ['report'=>$report, 'rep_m'=>$rep_m, 'date_ini'=>$date_ini, 'date_end'=>$date_end, 'rep_t'=>$rep_t,'compa'=>$compa, 'saldo'=>$saldo, 'tpagos'=>$montos, 'fname'=>$fname])->
        download('edocuenta_'.$rep_m->cname.'.pdf');

      }
    }
}
