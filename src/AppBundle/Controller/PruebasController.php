<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PruebasController extends Controller
{
    public function indexAction(Request $request, $name, $page)
    {
        
        //return $this->redirect($request->getBaseUrl()."/hello-world?hola=true");
        

        $productos =array(array("producto"=>"Consola","precio"=>2),
                    array("producto"=>"Consola 2","precio"=>3),
                    array("producto"=>"Consola 3","precio"=>4),
                    array("producto"=>"Consola 4","precio"=>5),
                    array("producto"=>"Consola 5","precio"=>6)
            );
        $fruta=array("manzana"=>"golden","pera"=>"rica");
        return $this->render('AppBundle:Pruebas:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'texto' => $name." - ".$page,
            'productos' => $productos,
            'fruta' => $fruta
        ]);
    }
}
