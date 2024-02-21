<?php

namespace App\Http\Controllers\Aplic\Analise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CifraController extends Controller
{
  
  public string $acordeConfirmado;
  public int    $sizeAcordeConfirmado;
  public array  $enarmonia             = ['se' => false, 'natureza' => null];//sus ou bem
  public bool   $tercaMenor            = false;
  public bool   $composto              = false;
  public array  $inversao              = ['se' => false, 'tom' => null, 'natureza' => null];// [V/F, tom, nat/sus/bem]
  public bool   $dissonancia           = false;

  public function setDissonancia(bool $get = false)
  {
    static $cont = 0;
    $this->dissonancia = true;
    $cont = $cont +1;
    if($get == true){
      $cont = 0;
      return 'n_diss';
    }
  }

  public function getDissonancia()
  {
    if($this->setDissonancia(true) == 'n_diss'){
      $this->dissonancia = false;
    }
    
  }
}
