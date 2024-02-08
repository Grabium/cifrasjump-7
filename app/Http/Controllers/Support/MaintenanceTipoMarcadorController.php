<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoMarcador;

class MaintenanceTipoMarcadorController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tipos_marcadores = new TipoMarcador();
    $tipos_marcadores = $tipos_marcadores->all();
    return response()->json($tipos_marcadores);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all(); //para retorno

    //try{
      $new_type = new TipoMarcador();
      $new_type->tipo = $request['type_name'];
      $new_type->save();

      return response()->json([
        'data' => [
          'msg' => 'Tipo: '.$data['type_name'].' cadastrado com sucesso!'
        ]
      ], 200);

    /*} catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }*/
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //try{
      $search_type = new TipoMarcador();
      $type = $search_type->findOrFail($id);

      return response()->json([
        'data' => $type
      ], 200);

    /*} catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }*/
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
    $new_type = $request->all();//para atualização

    //try{
      $old_type = new TipoMarcador();
      $old_type = $old_type->findOrFail($id);
      $old_type->update($new_type);

      return response()->json([
        'data' => [
          'msg' => 'Tipo atualizado com sucesso!'
        ]
      ], 200);

    /*} catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }*/
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //try{
      $to_destroy = new TipoMarcador();
      $to_destroy = $to_destroy->findOrFail($id);
      $data = $to_destroy['tipo'];
      $to_destroy->delete();

      return response()->json([
        'data' => [
          'msg' => 'Tipo: '.$data.' removida com sucesso!'
        ]
      ], 200);

    /*} catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }*/
  }
}
