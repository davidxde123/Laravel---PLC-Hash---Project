<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use App\GeneralFunction;
use App\User;


class RoleController extends Controller
{

      public function __construct(){

      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $roles = Role::all();
        $permissions = Permission::all();
        $dump_response = array();

        if(is_object($permissions))
            $dump_response =  GeneralFunction::generalErrors("success","Listados:",200,"Registros",
                array(["roles" => $roles, "permisos" => $permissions]));
        else
            $dump_response =  GeneralFunction::generalErrors("error","Listar",404, "No se encuentran registros");

        return response()->json($dump_response,$dump_response["code"]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $dump_response = array();

        $validator = Validator::make($request->all(), [ 
            'name' => 'required|unique:roles'
        ]);

        if ($validator->fails()) {            
             $dump_response = GeneralFunction::generalErrors("error","Crear",401,"Rol",$validator->errors());
        }else{


         if(Role::create($request->only('name'))):
          $dump_response =   GeneralFunction::generalErrors("success","Creado",200,"Rol");
         else:
           $dump_response =  GeneralFunction::generalErrors("error","Crear",404, "Rol","El rol no fue creado, vuelve a intentarlo");
         endif;  
        
        }

        return response()->json($dump_response, $dump_response["code"]); 
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {   

        

                
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {               


                $dump_response = array();
               if($role = Role::findOrFail($id)) {
                    // admin role has everything
                    if($role->name === 'Admin') {
                        $role->syncPermissions(Permission::all());
                        $dump_response = GeneralFunction::generalErrors("success","Actualizado",200,"Rol Administrador"); 
                    }

                    
                    $permissions = $request->get('permissions', []);
                    
        

                    if($request->get('enabled')){
                          $asignarPermiso = $role->syncPermissions($permissions);         
                          $dump_response= GeneralFunction::generalErrors("success","Actualizado",200, "Rol (".$role->name.")");
                    }else if(!$request->get('enabled')){
                          $asignarPermiso = $role->revokePermissionTo($permissions);         
                          $dump_response= GeneralFunction::generalErrors("success","Actualizado",200, "Rol (".$role->name.")");
                    }else{
                        $dump_response= GeneralFunction::generalErrors("error","Actualizar",403,"Rol: (".$role->name.")",
                         "Expecifica si vas a activar, o desactivar permisos, con la clave 'enabled:false/enabled:true' ");
                    }
                   
                 
         

                } else {
                    $dump_response= GeneralFunction::generalErrors("error","Actualizar",404, "Rol: ".$role->name,"El rol: ".$id." No se ha encontrado");
                }

                return response()->json($dump_response, $dump_response["code"]);
    
    }
        
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {


        
    }


}
