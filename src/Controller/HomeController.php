<?php

    namespace App\Controller;


    use App\Entity\User;
    use App\Form\UserType;
    use App\Repository\UserRepository;
    use App\Form\DiscussionType;
    use App\Repository\DiscussionRepository;
    use App\Entity\Post;
    use App\Entity\Discussion;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;

    class HomeController extends AbstractController{

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx HOME xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/", name="Home")
         */
        public function Home(DiscussionRepository $discussionRepository, UserRepository $userRepository){
            //var_dump('hello world');
            //die;
            $users = $userRepository -> findAll();
            $parcours = $discussionRepository ->findBy(['categorie'=>'1'], ['id'=>'DESC'], 3);

            return $this->render('Home.html.twig', [
                'parcours' => $parcours,
                'users'=>$users
            ]);
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
        public function Post(){
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

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Le profil xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/profil", name="profil")
         */
        public function profil(){
            //var_dump('hello world');
            //die;
            return $this->render('profil.html.twig');
        }


        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx inscription xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//https://symfonycasts.com/screencast/symfony-forms/registration-form

        /**
         * @route("/inscription", name="inscription")
         */
        public function inscription(
            Request $request,
            EntityManagerInterface $entityManager,
            UserPasswordEncoderInterface $passwordEncoder
        )
        {
            //nouvelle instance
            $user = new User();
            //recupération du gabarit de formulaire
            $userForm = $this->createForm(UserType ::class);
            //je prends les données de la requete et je les envois au formulaire
            $userForm->handleRequest($request);

            //si le formulaire a ete envoyé et que les données sont valides...
            if ($userForm->isSubmitted()&&$userForm->isValid()){
                //encoder le mot de passe :
                $user = $userForm->getData();
                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                ));

                //... alors je persist et flush le nouvel utilisateur
                $entityManager->persist($user);
                $entityManager->flush();
                //Un message de remerciement
                $this->addFlash('success', 'Merci de votre inscription');
                return $this->redirectToRoute('Home');
            }
            //par défaut j'affiche la page d'inscription
            return $this->render('inscription.html.twig', [
                'userForm'=>$userForm->createView()
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx les formulaires xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/formulaireDicussion/{id}", name="formulaireDicussion")
         */
        public function formulaireDicussion(
            Request $request,
            EntityManagerInterface $entityManager,
            UserRepository $UserRepository,
            $id
        )
        {
            //var_dump('hello world');
            //die;

            $userID = $UserRepository->find($id);
            $discussion = new Discussion();
            $discussionForm=$this->createForm(DiscussionType::class, $discussion);
            $discussionForm->handleRequest($request);

            if ($discussionForm->isSubmitted()&&$discussionForm->isValid()){
;
                $discussion->setUser($userID);
                $discussion->setNmbPost(0);
                $discussion->setDate(new \DateTime('now'));
                $entityManager->persist($discussion);
                $entityManager->flush();
                $this->addFlash('success', 'Votre Discussion a bien été crée !');
                return $this->redirectToRoute('profil');
            }else{

            }
            return $this->render('formulaireDiscussion.html.twig', [
            'discussionForm'=>$discussionForm->createView()
            ]);
        }



        /**
         * @route ("/formulaireGalerie", name="formulaireGalerie")
         */
        public function formulaireGalerie(){
            //var_dump('hello world');
            //die;
            return $this->render('formulaireGalerie.html.twig');
        }





    }

?>