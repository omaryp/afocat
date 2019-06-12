<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    //

    public function index(){
        $certificates = Certificate::select('certificates.id', 'certificates.codigo_certificado','certificates.ini_vigencia','certificates.fin_vigencia',
                             'certificates.apellido_paterno', 'certificates.apellido_materno','certificates.nombre','certificates.placa')
                ->orderBy('certificates.created_at', 'desc')
                ->paginate(7);
        $title = 'Listado de Ventas de Certificados';  
        return view('certificate.index',compact('certificates','title'));
    }

    public function create(){
        $title = 'Nueva Orden de Compra';
        $activo = TRUE;
        $forma_pago = ParametroController::getFormaPago();
        $des_recurso = ParametroController::getDestinosRecursos();
        $orden_codigo = Static::getCodigoOrden();
        $datos_vista = compact('activo','title','forma_pago','des_recurso','orden_codigo');
        return view('purchaseorder.form',$datos_vista);
    }

    public function search($valor){
        $orders = PurchaseOrder::join('proveedores', 'purchase_orders.proveedor_id', '=', 'proveedores.id')
        ->where('proveedores.razon_social', 'like',$valor.'%')
        ->orwhere('proveedores.ruc', 'like',$valor.'%')
        ->orderBy('purchase_orders.created_at', 'desc')
        ->take(5)
        ->get(['purchase_orders.id','proveedores.ruc', 'proveedores.razon_social','purchase_orders.fecha_emision','purchase_orders.total']);  
        return response()->json($orders);
    }

    public static function getCodigoOrden(){
        $maximo = PurchaseOrder::where('anio',date('Y'))->max('numero');
        $datos['numero'] = $maximo+1;
        $datos['anio'] = date('Y');
        return $datos;
    }

    public function store(){
        $data = request()->validate([
            'numero'=>'nullable',
            'anio'=>'nullable',
            'fecha_emision'=>'required|date_format:Y-m-d', 
            'destino'=>'required',
            'condicion_pago' => 'required',
            'plazo_dias' => 'required|numeric',
            'almacen' => 'required',
            'direccion' => 'required',
            'condiciones_entrega' => 'nullable',
            'proveedor_id' => 'required|numeric',
        ]);
            
        $ordenCompra = new PurchaseOrder();
        $ordenCompra->id = str_pad($data['numero'],6,"0",STR_PAD_LEFT).$data['anio'];
        $ordenCompra->numero=$data['numero'];
        $ordenCompra->anio=$data['anio'];
        $ordenCompra->fecha_emision=date_format(date_create($data['fecha_emision']), 'Y-m-d H:i:s');
        $ordenCompra->destino=$data['destino'];
        $ordenCompra->condicion_pago=$data['condicion_pago'];
        $ordenCompra->plazo_dias=$data['plazo_dias'];
        $ordenCompra->almacen=$data['almacen'];
        $ordenCompra->direccion=$data['direccion'];
        $ordenCompra->condiciones_entrega=$data['condiciones_entrega'];
        $ordenCompra->proveedor_id=$data['proveedor_id'];
        $ordenCompra->save();
        return redirect()->route('purchaseorders.edit',['codigo' => str_pad($data['numero'],6,"0",STR_PAD_LEFT).$data['anio']]);
    }
 
    public function show($codigo){
        $order = PurchaseOrder::select(
                 'purchase_orders.id', 
                 'proveedores.ruc', 
                 'proveedores.razon_social',
                 'purchase_orders.fecha_emision',
                 'purchase_orders.total', 
                 'purchase_orders.condicion_pago',
                 'purchase_orders.almacen',
                 'purchase_orders.direccion',
                 'purchase_orders.condiciones_entrega',
                 'parametros.descor')
                ->join('proveedores', 'purchase_orders.proveedor_id', '=', 'proveedores.id')
                ->join('parametros', 'parametros.codtab','=','purchase_orders.estado')
                ->where('parametros.codigo','=',1)
                ->where('parametros.codtab','<>',"''")
                ->where('purchase_orders.id','=',$codigo)
                ->get()->first();

        $order->fecha_emision = date_format(date_create($order->fecha_emision), 'Y-m-d');
        $title = 'Consulta Orden de Compra';
        $details = PurchaseOrderDetailController::getDetalleOrden($codigo);
        $activo = FALSE;
        return view('purchaseorder.form',compact('order','activo','title','details'));
    }

    public function edit($codigo){
        $order = PurchaseOrder::select(
            'purchase_orders.id', 
            'purchase_orders.numero', 
            'purchase_orders.anio', 
            'proveedores.ruc', 
            'proveedores.razon_social',
            'purchase_orders.fecha_emision',
            'purchase_orders.total',
            'purchase_orders.proveedor_id',
            'purchase_orders.plazo_dias',
            'purchase_orders.condicion_pago',
            'purchase_orders.destino',
            'purchase_orders.almacen',
            'purchase_orders.direccion',
            'purchase_orders.condiciones_entrega')
           ->join('proveedores', 'purchase_orders.proveedor_id', '=', 'proveedores.id')
           ->where('purchase_orders.id','=',$codigo)
           ->get()->first();
        $order->fecha_emision = date_format(date_create($order->fecha_emision), 'Y-m-d');
        $title = 'Actualizar Orden de Compra';
        $activo = TRUE;
        $forma_pago = ParametroController::getFormaPago();
        $des_recurso = ParametroController::getDestinosRecursos(); 
        $details = PurchaseOrderDetailController::getDetalleOrden($codigo);
        $datos_vista = compact('activo','title','forma_pago','des_recurso','order','details');
        return view('purchaseorder.form',$datos_vista);
    }

    public function update($codigo){
        $data = request()->validate([
            'numero'=>'nullable',
            'anio'=>'nullable',
            'fecha_emision'=>'required|date_format:Y-m-d', 
            'destino'=>'required',
            'condicion_pago' => 'required',
            'plazo_dias' => 'required|numeric',
            'almacen' => 'required',
            'direccion' => 'required',
            'condiciones_entrega' => 'nullable',
            'proveedor_id' => 'required|numeric',
        ]);    
        $order=PurchaseOrder::where('id','=',$codigo)->get()->first();
        $order->update($data);
        return redirect()->route('purchaseorders.edit',['codigo' =>$codigo]);
    }

    public static function actualizar_total($codigo,$monto){
        $order=PurchaseOrder::where('id','=',$codigo)->get()->first();
        $order->total+=$monto;
        $order->save();
    }
  
}
