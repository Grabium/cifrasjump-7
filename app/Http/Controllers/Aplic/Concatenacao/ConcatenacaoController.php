<?php

namespace App\Http\Controllers\Aplic\Concatenacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Aplic\Analise\CifraController;

class ConcatenacaoController extends Controller
{

  private array $arrayAcordes = [];
  private array $arrayLinhas  = [];
  private array $arrayNegat   = [];
  private array $caracteres   = [];
  private array $marcadores   = [];
  protected CifraController $cifra;
  
  
  public function faseConcatenacao(array $arraysPrincipais, array $marcadores):array
  {
    $this->arrayAcordes = $arraysPrincipais['arrayAcordes'];
    $this->arrayLinhas  = $arraysPrincipais['arrayLinhas'];
    $this->arrayNegat   = $arraysPrincipais['arrayNegat'];
    $this->marcadores   = $marcadores[0];
    $this->caracteres   = $marcadores[1];
    
    unset($arraysPrincipais, $marcadores);
    
    $this->changeMarcadoresCifras();
    //$tihs->inputMarcadoresLinhas();
    //$this->setLinhas();
    
    return [$linhasProntas, $achordesELinhas];
  }

  private function changeMarcadoresCifras()
  {
    //dd($this->arrayAcordes);
    collect($this->arrayAcordes)->map(function (CifraController $cifra){
      $this->cifra = $cifra;
      if($this->cifra->marcador['se'] == true){
        $r = array_search($this->cifra->marcador['marcador'], $this->marcadores);
        $this->cifra->acordeConfirmado = substr_replace(
          $this->cifra->acordeConfirmado,
          $this->caracteres[$r],
          $this->cifra->marcador['indexMarcador'],
          6);
        $this->cifra->tipagem = ($this->cifra->enarmonia['se'] == true)
          ?substr($this->cifra->acordeConfirmado, 2)
          :substr($this->cifra->acordeConfirmado, 1);
      }

      unset($this->cifra->marcador['indexMarcador'], $this->cifra->inversao['indexInversao']);
      dd($this->cifra);
    });
  }
}
