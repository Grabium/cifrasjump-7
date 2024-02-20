<?php

namespace App\Http\Controllers\Aplic\Analise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CifraController extends Controller
{
  
  public string $acordeConfirmado;
  public int    $sizeAcordeConfirmado;
  public array  $enarmonia             = [false, null];//sus ou bem
  public bool   $tercaMenor            = false;
  public bool   $composto              = false;
  public bool   $invercao              = false;
  public bool   $dissonancia           = false;
  
  
}
