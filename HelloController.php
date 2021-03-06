<?php
//試しにこのファイルをRyosuke-0311/hello-worldにPushできるかやってみます。
namespace App\Controller;


use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class HelloController extends AbstractController
{
    
    /**
     * @Route("/hello", name="hello")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()//Doctrineオブジェクト（symfonyに用意されているORMプログラム）を取得
            ->getRepository(Person::class);//Doctrineに用意されているgetRepositoryメソッドでリポジトリを取得。引数にはエンティティのclassプロパティを指定
            $data = $repository->findall();//findallは、リポジトリに関連づけられているエンティティの配列を取得
            return $this->render('hello/index.html.twig', [
               'title' => 'Hello',
               'data' => $data,
           ]);
    }
    


    /**
 * @Route("/find/{id}", name="find")
 */
    public function find(Request $request, Person $person)
    {
        return $this->render('hello/find.html.twig', [
            'title' => 'Hello',
            'data' => $person,
        ]);
    }

/**
 * @Route("/create", name="create")
 */
public function create(Request $request)
{
    $person = new Person();
    $form = $this->createFormBuilder($person)
        ->add('name', TextType::class)
        ->add('mail', TextType::class)
        ->add('age', IntegerType::class)
        ->add('save', SubmitType::class, array('label' => 'Click'))
        ->getForm();


    if ($request->getMethod() == 'POST'){
        $form->handleRequest($request);
        $person = $form->getData();
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($person);
        $manager->flush();
        return $this->redirect('/hello');
    } else {
        return $this->render('hello/create.html.twig', [
            'title' => 'Hello',
            'message' => 'Create Entity',
            'form' => $form->createView(),
        ]); 
    }
}
 /**
 * @Route("/update/{id}", name="update")
 */
public function update(Request $request, Person $person)
{
    $form = $this->createFormBuilder($person)
        ->add('name', TextType::class)
        ->add('mail', TextType::class)
        ->add('age', IntegerType::class)
        ->add('save', SubmitType::class, array('label' => 'Click'))
        ->getForm();


    if ($request->getMethod() == 'POST'){
        $form->handleRequest($request);
        $person = $form->getData();
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();
        return $this->redirect('/hello');
    } else {
        return $this->render('hello/create.html.twig', [
            'title' => 'Hello',
            'message' => 'Update Entity id=' . $person->getId(),
            'form' => $form->createView(),
        ]); 
    }
}

/**
 * @Route("/delete/{id}", name="delete")
 */
public function delete(Request $request, Person $person)
{
    $form = $this->createFormBuilder($person)
        ->add('name', TextType::class)
        ->add('mail', TextType::class)
        ->add('age', IntegerType::class)
        ->add('save', SubmitType::class, array('label' => 'Click'))
        ->getForm();


    if ($request->getMethod() == 'POST'){
        $form->handleRequest($request);
        $person = $form->getData();
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($person);
        $manager->flush();
        return $this->redirect('/hello');
    } else {
        return $this->render('hello/create.html.twig', [
            'title' => 'Hello',
            'message' => 'Delete Entity id=' . $person->getId(),
            'form' => $form->createView(),
        ]); 
    }
}

}

class FindForm
{
    private $find;


    public function getFind()
    {
        return $this->find;
    }
    public function setFind($find)
    {
        $this->find = $find;
    }
}
