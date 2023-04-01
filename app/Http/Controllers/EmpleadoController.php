<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $empleados=DB::table('empleados')
                    ->select('id','Nombre','ApellidoMaterno','ApellidoPaterno','NumeroTelefono','Correo','Rut','TipoMembresia','Foto')
                    ->where('ApellidoPaterno','LIKE','%'.$texto.'%')
                    ->orWhere('Nombre','LIKE','%'.$texto.'%')
                    ->orWhere('ApellidoMaterno','LIKE','%'.$texto.'%')
                    ->paginate(5);
        //$datos['empleados'] = Empleado::paginate(5);
        return view('empleado.index',compact('empleados','texto'));//-> la variable $datos se debe pasar a la vista especificado como variable
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$datosEmpleado = request()->all();
        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'NumeroTelefono'=>'required|string|max:100',
            'Rut'=>'required|string|max:100',
            'FechaNacimiento'=>'required|string|max:100',
            'TipoMembresia'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg'
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La foto es requerida'
        ];
        $this->validate($request,$campos,$mensaje);


        $datosEmpleado = request()->except('_token');
        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }
        Empleado::insert($datosEmpleado);
        
        return redirect('empleado')->with('mensaje','Miembro creado con éxito');
        //return response()->json($datosEmpleado);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //recuperar los datos de la vista
        $empleado= Empleado::findOrFail($id);
        return view('empleado.edit',compact('empleado') );//retornalo a la vista editar empleado
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //metodo para actualizar los datos para el empleado en la base de datos
        $datosEmpleado = request()->except(['_token','_method']);
        if($request->hasFile('Foto')){
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        Empleado::where('id','=',$id)->update($datosEmpleado);
        $empleado = Empleado::findOrFail($id);
        return redirect('empleado')->with('mensaje','Miembro editado con éxito');
        //return view('empleado.edit',compact('empleado'));//retornalo a la vista editar empleado
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//eliminar un empleado
    {
        $empleado = Empleado::findOrFail($id);

        //preguntar si la foto existe, si no ,se borra
        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        }
        
        return redirect('empleado')->with('mensaje','Empleado eliminado');
    }
}
