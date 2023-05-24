<?php

namespace App\Controller;
use App\Form\NewsType;
use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewsController extends AbstractController
{
    
    /**
     * @Route("/Admin/news", name="app_news")
     */
    public function index(): Response
    {
        $news = $this->getDoctrine()->getManager()->getRepository(News::class)->findAll();
        return $this->render('news/index.html.twig', [
          'n'=>$news
        ]);
    }
    public function showNews(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->findAll();
        
        return $this->redirectToRoute('Client', [
            'news' => $news,
        ]);
    }
    


    /**
     * @Route("/addNew", name="app_addNew")
     */
    public function addNew(Request $request): Response
    {
        $new = new News();

        $form = $this->createForm(NewsType::class,$new);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
             /** @var UploadedFile $imageFile */
             $imageFile = $form->get('imageFile')->getData();

             if ($imageFile) {
               $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
               $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
           
               try {
                   $imageFile->move(
                       $this->getParameter('news_images_directory'),
                       $newFilename
                   );
               } catch (FileException $e) {
                   // handle exception if something happens during file upload
               }
           
               // update the Player entity with the new image path
               $new->setImage($newFilename);
             }
            $em = $this->getDoctrine()->getManager();
            $em->persist($new); //add
            $em->flush();

            return $this->redirectToRoute('app_news');
        }
        return $this->render('news/createNew.html.twig',['f'=>$form->createView()]);
    }
    /**
     * @Route("/supNew/{id}", name="app_supNew")
     */
    public function suppressionNew(News $new): Response
{
    $em = $this->getDoctrine()->getManager();
    $imageFilename = $new->getImageFilename();

    if ($imageFilename) {
        $imagePath = $this->getParameter('uploads/news_images').'/'.$imageFilename;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $em->remove($new);
    $em->flush();

    return $this->redirectToRoute('app_news');
}
/**
     * @Route("/modNew/{id}", name="app_modNew")
     */
    public function modNew(Request $request,$id): Response
    {
        $new = $this->getDoctrine()->getManager()->getRepository(News::class)->find($id);

        $form = $this->createForm(NewsType::class,$new);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {
              /** @var UploadedFile $imageFile */
              $imageFile = $form->get('imageFile')->getData();

              if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
            
                try {
                    $imageFile->move(
                        $this->getParameter('news_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }
            
                // update the Player entity with the new image path
                $new->setImage($newFilename);
              }
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_news');
        }
        return $this->render('news/updateNew.html.twig',['f'=>$form->createView()]);
    }

}
