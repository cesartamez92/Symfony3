<?php

namespace AppBundle\Controller;

use AppBundle\Form\CursoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Curso;
use Symfony\Component\Validator\Constraints as Assert;

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
    
    public function createAction(){
        
        $curso = new Curso();
        $curso->setTitulo("Curso de Symfony3");
        $curso->setDescripcion("Curso completo de Symfony3");
        $curso->setPrecio(80);
        
        //A partir de la version 3.0.6 se descontinua el getEntityManager y se usa getManager
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($curso);
        $flush=$em->flush();
        
        if($flush!= null){
            echo "El curso no se ha creado bien!!";
        } else {
            echo "El curso se ha creado correctamente";
        }
        
        die();
    }
    
    public function readAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        $cursos = $cursos_repo->findAll();
        
        $curso_ochenta=$cursos_repo->findOneByPrecio(80);
        echo $curso_ochenta->getTitulo();
        
        
//        foreach($cursos as $curso){
//            echo $curso->getTitulo()."<br/>";
//            echo $curso->getDescripcion()."<br/>";
//            echo $curso->getPrecio()."<br/><hr/>";
//        }
        
        die();
    }
    
    public function updateAction($id,$titulo,$descripcion,$precio){
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        
        $curso = $cursos_repo->find($id);
        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setPrecio($precio);
        
        $em->persist($curso);
        $flush=$em->flush();
        
        if($flush!=null){
            echo "El Curso no se ha actualizado!";
        } else {
            echo "El curso se ha actualizado correctamente";
        }
        
        die();
    }
    
    public function deleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        
        $curso = $cursos_repo->find($id);
        $em->remove($curso);
        $flush=$em->flush();
        
        if($flush!=null){
            echo "El Curso no se ha eliminado!!";
        } else {
            echo "El curso se ha eliminado correctamente";
        }
        
        die();
    }
    
    public function nativeSqlAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
//        $db = $em->getConnection();
//        $query = "SELECT * from cursos";
//        $stmt = $db->prepare($query);
//        $params = array();
//        $stmt->execute($params);
//        
//        $cursos = $stmt->fetchAll();
        
//        $query = $em->createQuery("
//                SELECT c FROM AppBundle:Curso c
//                WHERE c.precio > :precio
//                ")->setParameter("precio","79");
//        $cursos = $query->getResult();
        
        $cursos = $cursos_repo->getCursos();
        
        foreach($cursos as $curso){
            echo $curso->getTitulo()."<br/>";
        }
        
        die();
    }

    public function formAction(Request $request){
        $curso = new Curso;
        $form = $this->createForm(CursoType::class);

        $form->handleRequest($request);

        if($form->isValid()){
            $status = "Formulario Valido";
            $data = array(
                "titulo" => $form->get("titulo")->getData(),
                "descripcion" => $form->get("descripcion")->getData(),
                "descripcion" => $form->get("descripcion")->getData(),
                "precio" => $form->get("precio")->getData()
            );
        } else {
            $status = null;
            $data = null;
        }

        return $this->render('AppBundle:Pruebas:form.html.twig',array(
            'form' => $form->createView(),
            'status' => $status,
            'data' => $data
        ));
    }

    public function validarEmailAction($email){
        $emailConstraint =  new Assert\Email();
        $emailConstraint->message = "Pasame un buen correo";

        $error= $this->get("validator")->validate(
            $email,
            $emailConstraint
        );

        if(count($error)==0){
            echo "<h1>Correo Valido</h1>";
        } else {
            echo $error[0]->getMessage();
        }

        die();
    }
}
