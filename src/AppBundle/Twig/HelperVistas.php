<?php
namespace AppBundle\Twig;

class HelperVistas extends \Twig_Extension{
    
    public function getFunctions(){
        return array(
            'generateTable' => new \Twig_Function_Method($this, 'generateTable') 
       );
    }
    
    public function generateTable($num_colmns,$num_rows){
        $table="<table class_'table' border=1>";
        for($i=0; $i<$num_rows; $i++){
            $table.="<tr>";
            for($f=0; $f<$num_colmns; $f++){
                $table.="<td>COLUMNA</td>";
            }
            $table.="<tr>";
        }
        $table.="</table>";
        return $table;
    }
    
    public function getName(){
        return "app_bundle";
    }
}
