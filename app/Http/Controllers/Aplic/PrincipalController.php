<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{

  private LeituraController $leitura;

  public function __construct(Request $request)
  {
    $this->leitura = new LeituraController($request['texto']);
  }
  
  public function master()
  {
    //$fator = $request['fator'];
    $textoRecebido = $this->leitura->getTextoRecebido();
    return response()->json(['msg' => [$textoRecebido]]);
  }
}
