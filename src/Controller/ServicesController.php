<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Mascota;
use App\Entity\Recordatorio;
use App\Entity\Evento;
use App\Entity\Vacuna;
use App\Entity\Paseo;
use App\Entity\Emparejamiento;
use \Datetime;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class ServicesController extends AbstractController{
    /**
     * @Route("/",name="home")
     */
    public function index(){
        //return new Response('<html><body>Hello</body></html>');
        $pets = array("pet1"=>"kiara","pet2"=>"luna");
        //return $this->render('services/index.html.twig');
        return new JsonResponse($pets);
    }

    /**
     * @Route("/registrar/usuario/")
     * @Method({"GET"})
     */
    public function registrarUsuario(){
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = new Usuario();
        $usuario->setNombre($_GET["nombre"]);
        $usuario->setApellido($_GET["apellido"]);
        $usuario->setTelefono($_GET["telefono"]);
        $usuario->setEmail($_GET["email"]);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return new Response('Created user with id '.$usuario->getId());
    }

    /**
     * @Route("/registrar/mascota/")
     * @Method({"GET"})
     */
    public function registrarMascota(){
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->getDoctrine()->getRepository(Usuario::class)
        ->find((int)$_GET["usuario"]);
        $mascota = new Mascota();
        $mascota->setNombre($_GET["nombre"]);
        $mascota->setFechanacimiento(new DateTime($_GET["fechana"]));
        $mascota->setEspecie($_GET["especie"]);
        $mascota->setRaza($_GET["raza"]);
        $mascota->setGenero($_GET["genero"]);
        $mascota->setEncelo($_GET["encelo"]);
        $mascota->setUsuario($usuario);

        $em->persist($mascota);
        $em->flush();

        return new Response('Created pet with id '.$mascota->getId().
        ' with owner\'s name '.$usuario->getNombre());
        
    }
    
    /**
     * @Route("/ver/mascotas/{usuario}")
     * @Method({"GET"})
     */
    public function verMascotasDueno($usuario){
        $mascotas = $this->getDoctrine()->getRepository(Mascota::class)
        ->findBy(array('usuario'=>$usuario));
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->serialize($mascotas,'json');

        return new Response($result);
    }
    
    
    /**
     * @Route("/ver/vacunas/{mascota}")
     * 
     */
    public function verVacunasMascota($mascota){
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $vacunas = $doctrine->getRepository(Vacuna::class)
        ->findAll();
        $vacMascota = array();
        foreach($vacunas as $vac){
            if($vac->getEvento()->getMascota()->getId() == $mascota){
                array_push($vacMascota, $vac);
            }
        }
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->serialize($vacMascota,'json');
        return new Response($result);
    }
    

    /**
     * @Route("/ver/parejas/{mascota}")
     */
    public function verParejasMascota($mascota){
        $doctrine = $this->getDoctrine();
        $interesado = $doctrine->getRepository(Mascota::class)
        ->find($mascota);

        $generoPareja = '';
        if($interesado->getGenero()=="macho")
            $generoPareja = 'hembra';
        else
            $generoPareja = 'macho';
        $pretendientes = $doctrine->getRepository(Mascota::class)
        ->findBy(array('genero'=>$generoPareja,
        'raza'=>$interesado->getRaza(),'encelo'=>True));

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->serialize($pretendientes,'json');
        return new Response($result);
    }

    /**
     * @Route("/guardar/paseo/")
     * @Method({"GET"})
     */
    public function registrarPaseo(){
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $mascota = $doctrine->getRepository(Mascota::class)
        ->find($_GET["mascota"]);

        $recordatorio = new Recordatorio();
        $recordatorio->setProximafecha(new Datetime($_GET["fecha"]));
        $recordatorio->setPeriodocantidad(0);
        $recordatorio->setPeriodounidad("noaplica");
        $evento = new Evento();
        $evento->setEstado("NOCUMPLIDO");
        $evento->setMascota($mascota);
        $evento->setRecordatorio($recordatorio);
        $paseo = new Paseo();
        $paseo->setLugar($_GET["lugar"]);
        $paseo->setEvento($evento);

        $em->persist($recordatorio);
        $em->persist($evento);
        $em->persist($paseo);

        $em->flush();

        return new Response('Walk planned for pet with id'.$mascota->
        getId());
    }
    /**
     * @Route("/guardar/vacuna/")
     * @Method({"GET"})
     */
    public function registrarVacuna(){

        $em = $this->getDoctrine()->getManager();
        $mascota = $doctrine->getRepository(Mascota::class)
        ->find($_GET["mascota"]);

        $recordatorio = new Recordatorio();
        $recordatorio->setProximafecha(new Datetime($_GET["fecha"]));
        $recordatorio->setPeriodocantidad(0);
        $recordatorio->setPeriodounidad("noaplica");
        $evento = new Evento();
        $evento->setEstado("NOCUMPLIDO");
        $evento->setMascota($mascota);
        $evento->setRecordatorio($recordatorio);
        $vacuna = new Vacuna();
        $vacuna->setNombre($_GET["nombre"]);
        $vacuna->setCantidad($_GET["cantidad"]);
        $vacuna->setEvento($evento);
       
        $em->persist($recordatorio);
        $em->persist($evento);
        $em->persist($vacuna);
        $em->flush();

        return new Response('Created vaccine'.$vacuna->getNombre(). 'for the pet with id '.$mascota->getId().
        ' with owner\'s name '.$usuario->getNombre());
    }

    /**
     * @Route("/guardar/pareja/")
     * @Method({"GET"})
     */
    public function registrarEmparejamiento(){

        $em = $this->getDoctrine()->getManager();
        $mascota = $doctrine->getRepository(Mascota::class)
        ->find($_GET["mascota"]);

        $recordatorio = new Recordatorio();
        $recordatorio->setProximafecha(new Datetime($_GET["fecha"]));
        $recordatorio->setPeriodocantidad(0);
        $recordatorio->setPeriodounidad("noaplica");
        $evento = new Evento();
        $evento->setEstado("NOCUMPLIDO");
        $evento->setMascota($mascota);
        $evento->setRecordatorio($recordatorio);
        $emparejamiento = new Emparejamiento();
        $emparejamiento->setMacho($_GET["macho"]);
        $emparejamiento->setHembra($_GET["hembra"]);
        $emparejamiento->setEvento($evento);
       
        $em->persist($recordatorio);
        $em->persist($evento);
        $em->persist($emparejamiento);
        $em->flush();

        return new Response('Created love match for the pet with id '.$mascota->getId().
        ' with owner\'s name '.$usuario->getNombre());
    }

    /**
     * @Route("/eliminar/pareja/")
     * @Method({"GET"})
     */
    public function eliminarEmparejamiento($emparejamiento){

        $doctrine = $this->getDoctrine();
        $empareja = $doctrine->getRepository(Emparejamiento::class)
        ->find($emparejamiento);

        unset($empareja);

        return new Response('Delete love match ');
    }

    /**
     * @Route("/eliminar/vacuna/")
     * @Method({"GET"})
     */
    public function eliminarVacuna($vacuna){

        $doctrine = $this->getDoctrine();
        $vacu = $doctrine->getRepository(Vacuna::class)
        ->find($vacuna);

        unset($vacu);

        return new Response('Delete vaccine ');
    }

    /**
     * @Route("/eliminar/paseo/")
     * @Method({"GET"})
     */
    public function eliminarPaseo($paseo){

        $doctrine = $this->getDoctrine();
        $pas = $doctrine->getRepository(Paseo::class)
        ->find($paseo);

        unset($pas);

        return new Response('Delete walk planned');
    }

    /**
     * @Route("/modificar/paseo/")
     * @Method({"GET"})
     */
    public function modificarPaseo($paseo){

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $pass = $doctrine->getRepository(Paseo::class)
        ->find($paseo);

        $recordatorio = new Recordatorio();
        $recordatorio->setProximafecha(new Datetime($_GET["fecha"]));
        $recordatorio->setPeriodocantidad(0);
        $recordatorio->setPeriodounidad("noaplica");
        $evento = new Evento();
        $evento->setEstado("NOCUMPLIDO");
        $evento->setMascota($mascota);
        $evento->setRecordatorio($recordatorio);
        $pass->setLugar($_GET["lugar"]);
        $pass->setEvento($evento);

        $em->persist($recordatorio);
        $em->persist($evento);
        $em->persist($pass);

        $em->flush();

        return new Response('Modified walk planned for pet with id'.$mascota->
        getId());
    }

    /**
     * @Route("/modificar/vacuna/")
     * @Method({"GET"})
     */
    public function modificarVacuna($vacuna){

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $vac = $doctrine->getRepository(Paseo::class)
        ->find($vacuna);

        $recordatorio = new Recordatorio();
        $recordatorio->setProximafecha(new Datetime($_GET["fecha"]));
        $recordatorio->setPeriodocantidad(0);
        $recordatorio->setPeriodounidad("noaplica");
        $evento = new Evento();
        $evento->setEstado("NOCUMPLIDO");
        $evento->setMascota($mascota);
        $evento->setRecordatorio($recordatorio);
        $vac->setNombre($_GET["nombre"]);
        $vac->setCantidad($_GET["cantidad"]);
        $vac->setEvento($evento);
       
        $em->persist($recordatorio);
        $em->persist($evento);
        $em->persist($vacuna);
        $em->flush();

        return new Response('Modified vaccine'.$vacuna->getNombre(). 'for the pet with id '.$mascota->getId().
        ' with owner\'s name '.$usuario->getNombre());
    }

}