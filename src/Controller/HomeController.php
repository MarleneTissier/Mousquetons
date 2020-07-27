<?php

    namespace App\Controller;


    use App\Entity\User;
    use App\Form\UserType;
    use App\Repository\UserRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;

    class HomeController extends AbstractController{

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx HOME xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/", name="Home")
         */
        public function Home(){
            //var_dump('hello world');
            //die;
            return $this->render('Home.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx COURSE xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/parcours", name="Course")
         */
        public function Course(){
            //var_dump('hello world');
            //die;
            return $this->render('Course.html.twig');
        }

        /**
         * @route ("/parcours/discussions", name="CourseDiscussion")
         */
        public function CourseDiscussion(){
            //var_dump('hello world');
            //die;
            return $this->render('Course_Discussion.html.twig');
        }


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx PLACES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/lieux", name="Places")
         */
        public function Places(){
            //var_dump('hello world');
            //die;
            return $this->render('Places.html.twig');
        }

        /**
         * @route ("/lieux/discussions", name="PlacesDiscussion")
         */
        public function PlacesDiscussion(){
            //var_dump('hello world');
            //die;
            return $this->render('Places_Discussion.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ACTIVITIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/activitées", name="Activities")
         */
        public function Activities(){
            //var_dump('hello world');
            //die;
            return $this->render('Activities.html.twig');
        }

        /**
         * @route ("/activitées/discussions", name="ActivitiesDiscussion")
         */
        public function ActivitiesDiscussion(){
            //var_dump('hello world');
            //die;
            return $this->render('Activities_Discussion.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx GALERIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/galeries", name="Galeries")
         */
        public function Galeries(){
            //var_dump('hello world');
            //die;
            return $this->render('Galeries.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx LES POST xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/postTitle", name="post")
         */
        public function post(){
            //var_dump('hello world');
            //die;
            return $this->render('Post.html.twig');
        }

        /**
         * @route ("/imagesTitle", name="images")
         */
        public function images(){
            //var_dump('hello world');
            //die;
            return $this->render('Album.html.twig');
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx LES POST xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/recherche", name="search")
         */
        public function search(){
            //var_dump('hello world');
            //die;
            return $this->render('Search.html.twig');
        }


        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Les formalitées xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/formalité", name="formalitees")
         */
        public function formalitees(){
            //var_dump('hello world');
            //die;
            return $this->render('Formalitees.html.twig');
        }


        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Connexion xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/connexion", name="connexion")
         */
        public function connexion(){
            //var_dump('hello world');
            //die;
            return $this->render('inscription.html.twig');
        }

        /**
         * @route("/inscription", name="inscription")
         */
        public function inscription(
            Request $request,
            EntityManagerInterface $entityManager,
            UserRepository $userRepository
        )
        {
            //nouvelle instance
            $user = new User();
            //recupération du gabarit de formulaire
            $userForm = $this->createForm(UserType ::class, $user);
            //je prends les données de la requete et je les envois au formulaire
            $userForm->handleRequest($request);
            //si le formulaire a ete envoyé et que les données sont valides...
            if ($userForm->isSubmitted()&&$userForm->isValid()){
                //... alors je persist et flush le livre
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Merci de votre inscription');
                return $this->redirectToRoute('Home');
            }
            return $this->render('inscription.html.twig', [
                'userForm'=>$userForm->createView()
            ]);
        }

    }

?>