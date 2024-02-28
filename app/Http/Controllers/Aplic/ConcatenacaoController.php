<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConcatenacaoController extends Controller
{
  public function faseConcatenacao(array $achordesConvertidos, array $marcadores):array
  {
    //dd($marcadores);
    return $achordesConvertidos;
  }
}
