<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
  public function master(Request $request)
  {
    $fator = $request['fator'];
    $texto = $request['texto'];
    return response()->json(['msg' => [$fator, $texto]]);
  }
}
