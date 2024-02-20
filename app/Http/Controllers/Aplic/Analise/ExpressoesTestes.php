<?php
//$teste1 = 'tudo ok no require';
$espaçoOuInversao = (($this->ac == ' ')||($this->cifra->invercao == true ));

$ouMiOuLaMaiorOuMenor = ((($this->chor[0] == "E")||($this->chor[0] == "A"))
                 &&(($this->s == 1)||(($this->s == 2)&&($this->chor[1] == 'm')))
                 &&($this->cifra->invercao == false ));

$menor = ((($this->ac == 'm')&&($this->s == 1))
          //&&($this->cifra->composto == false)
          ||(($this->ac == 'm')
             &&($this->s == 2)
             &&($this->cifra->enarmonia == true )
             /*&&($this->cifra->composto == false )*/));
?>