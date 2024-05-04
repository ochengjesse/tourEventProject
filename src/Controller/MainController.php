<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\TourTable;
use App\Form\CrudType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(EntityManagerInterface $em): Response
    {
        $data = $em->getRepository(TourTable::class)->findAll();
        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $tour = new TourTable();
        $form = $this->createForm(CrudType::class, $tour);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        
            $em->persist($tour);
            $em->flush();
            //Display the message 

           $this->addFlash('notice','Submitted');
           return $this->redirectToRoute('app_main');
        }

        return $this->render('main/create.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, EntityManagerInterface $em, int $id )
    {
        $data = $em->getRepository(TourTable::class)->find($id);
        $form = $this->createForm(CrudType::class, $data);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        
            $em->persist($data);
            $em->flush();
            //Display the message 

           $this->addFlash('notice','Update successful');
           return $this->redirectToRoute('app_main', [
            'id' => $data->getId()
        ]);
        }

        return $this->render('main/update.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $em, int $id){
        $data = $em->getRepository(TourTable::class)->find($id);

        $em->remove($data);
            $em->flush();
            //Display the message 

           $this->addFlash('notice','Deleted succcesfully');
           return $this->redirectToRoute('app_main', );
    }

}
