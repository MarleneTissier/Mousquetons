<?php

    namespace App\Controller;


    use App\Entity\Post;
    use App\Entity\Profil;
    use App\Form\PostType;
    use App\Form\UserUpdateType;
    use App\Repository\DiscussionRepository;
    use App\Repository\PostRepository;
    use App\Repository\ProfilRepository;
    use App\Repository\UserRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\File\Exception\FileException;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\String\Slugger\SluggerInterface;

    class AdminController extends AbstractController
    {

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx HOME xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin", name="HomeAdmin")
         */
        public function Home(
            DiscussionRepository $discussionRepository,
            UserRepository $userRepository
        )
        {
            //var_dump('hello world');
            //die;

            $users = $userRepository->findAll();
            $parcours = $discussionRepository->findBy(['categorie' => '1'], ['id' => 'DESC'], 3);
            $lieux = $discussionRepository->findBy(['categorie' => '2'], ['id' => 'DESC'], 3);
            $activites = $discussionRepository->findBy(['categorie' => '3'], ['id' => 'DESC'], 3);

            return $this->render('Home.html.twig', [
                'parcours' => $parcours,
                'lieux' => $lieux,
                'activites' => $activites,
                'users' => $users
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx COURSE xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/parcours", name="AdminCourse")
         */
        public function Course(DiscussionRepository $discussionRepository)
        {
            //var_dump('hello world');
            //die;
            $parcoursFrance = $discussionRepository->findBy(array('categorie' => '1', 'place' => '1'), ['id' => 'DESC']);
            $parcoursEspagne = $discussionRepository->findBy(array('categorie' => '1', 'place' => '2'), ['id' => 'DESC']);
            $parcoursEurope = $discussionRepository->findBy(array('categorie' => '1', 'place' => '3'), ['id' => 'DESC']);
            $parcoursMonde = $discussionRepository->findBy(array('categorie' => '1', 'place' => '4'), ['id' => 'DESC']);
            return $this->render('Admin/Course.html.twig', [
                'parcoursFrance' => $parcoursFrance,
                'parcoursEspagne' => $parcoursEspagne,
                'parcoursEurope' => $parcoursEurope,
                'parcoursMonde' => $parcoursMonde
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx PLACES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/lieux", name="AdminPlaces")
         */
        public function Places(DiscussionRepository $discussionRepository){
            //var_dump('hello world');
            //die;
            $lieuxFrance = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'1'), ['id'=>'DESC']);
            $lieuxEspagne = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'2'), ['id'=>'DESC']);
            $lieuxEurope = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'3'), ['id'=>'DESC']);
            $lieuxMonde = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'4'), ['id'=>'DESC']);
            return $this->render('Admin/Places.html.twig',[
                'lieuxFrance'=> $lieuxFrance,
                'lieuxEspagne'=> $lieuxEspagne,
                'lieuxEurope'=> $lieuxEurope,
                'lieuxMonde'=> $lieuxMonde
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ACTIVITIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/activitées", name="AdminActivities")
         */
        public function Activities(DiscussionRepository $discussionRepository){
            //var_dump('hello world');
            //die;
            $activitesFrance = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'1'), ['id'=>'DESC']);
            $activitesEspagne = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'2'), ['id'=>'DESC']);
            $activitesEurope = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'3'), ['id'=>'DESC']);
            $activitesMonde = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'4'), ['id'=>'DESC']);
            return $this->render('Admin/Activities.html.twig',[
                'activitesFrance'=> $activitesFrance,
                'activitesEspagne'=> $activitesEspagne,
                'activitesEurope'=> $activitesEurope,
                'activitesMonde'=> $activitesMonde
            ]);
        }
        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx GALERIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/galeries", name="AdminGaleries")
         */
        public function Galeries(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/Galeries.html.twig');
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx La recherche xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/recherche", name="Adminsearch")
         */
        public function search(
            DiscussionRepository $discussionRepository,
            Request $request
        ){
            //var_dump('hello world');
            //die;
            //utiliser la class request pour récup la valeur ds l'url qui est envoyée par le formulaire
            $word = $request->query->get('search');
            //initialiser la variable discussion
            $discussion=[];
            if (!empty($word)){
                //si elle n'est pas vide, renvoyer le résultat fourni par la méthode DiscussionFindByResum
                //présent dans le repository DiscussionRepository
                $discussion=$discussionRepository->DiscussionFindByResum($word);
            }
            return $this->render('Admin/Search.html.twig', [
                'discussions'=>$discussion
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Les posts xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/postTitle/{id}", name="Adminpost")
         */
        public function Post(DiscussionRepository $discussionRepository,
                             PostRepository $postRepository,
                             EntityManagerInterface $entityManager,
                             UserRepository $userRepository,
                             Request $request,
                             ?UserInterface $user,
                             $id)
        {
            //dump('hello world');
            //die;
            $discussion = $discussionRepository->find($id);
            $discussionID = $discussionRepository->find($id);
            $discussionPosts = $postRepository->findBy(array('discussion' => $id));
            $post = new Post();
            $PostForm = $this->createForm(PostType ::class, $post);

            if ($user) {
                $idUser = $this->getUser()->getId();
                $userID = $userRepository->find($idUser);
                $PostForm->handleRequest($request);


                if ($PostForm->isSubmitted() && $PostForm->isValid()) {
                    $post->setUser($userID);
                    $post->setDiscussion($discussionID);
                    $entityManager->persist($post);
                    $entityManager->flush();
                    $this->addFlash('success', 'Votre post a bien été créé !');
                    //$post = new Post();
                    //$PostForm = $this->createForm(PostType ::class, $post);
                    return $this->redirectToRoute('Adminpost', array('id' => $id));
                }
            }


            return $this->render('Admin/Post.html.twig', [
                'discussion'=>$discussion,
                'discussionPosts'=>$discussionPosts,
                'postForm' => $PostForm->createView()
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Les discussions xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/parcours/discussions/{id}", name="AdminCourseDiscussion")
         */
        public function CourseDiscussion(DiscussionRepository $discussionRepository, $id){
            //var_dump('hello world');
            //die;
            $parcours = $discussionRepository ->findBy(array('categorie'=>'1', 'place'=>$id), ['id'=>'DESC']);
            return $this->render('Admin/Course_Discussion.html.twig', [
                'parcours' => $parcours
            ]);
        }

        /**
         * @route ("/admin/lieux/discussions/{id}", name="AdminPlacesDiscussion")
         */
        public function PlacesDiscussion(DiscussionRepository $discussionRepository, $id){
            //var_dump('hello world');
            //die;
            $lieux = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>$id), ['id'=>'DESC']);
            return $this->render('Admin/Places_Discussion.html.twig',[
                'lieux'=> $lieux
            ]);
        }


        /**
         * @route ("/admin/activitées/discussions/{id}", name="AdminActivitiesDiscussion")
         */
        public function ActivitiesDiscussion(DiscussionRepository $discussionRepository, $id){
            //var_dump('hello world');
            //die;
            $activites = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>$id), ['id'=>'DESC']);

            return $this->render('Admin/Activities_Discussion.html.twig',[
                'activites'=>$activites
            ]);
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Les suppressions xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx


        /**
         * @route ("/admin/deletePost/{id}", name="AdminDeletePost")
         */
        public function AdminDeletePost(
            PostRepository $postRepository,
            EntityManagerInterface $entityManager,
            $id){
            //var_dump('hello world');
            //die;
            $post = $postRepository->find($id);
            //dump($id);
            //dump ($post);
            //die();
            $entityManager->remove($post);
            $entityManager->flush();
            $this->addFlash('success', 'Votre post a été supprimé !');
            return $this->redirectToRoute('HomeAdmin');
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Les profils xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx


        /**
         * @route ("/admin/profil", name="Adminprofil")
         */
        public function profil(
            UserRepository $userRepository,
            ProfilRepository $profilRepository,
            DiscussionRepository $discussionRepository
        ){
            //récupérer l'id de la personne connectée
            $id = $this->getUser()->getId();
            $userID = $userRepository->find($id);
            //récupérer l'avatar selon l'id
            $userAvatar = $this->getUser()->getProfil()->getAvatar();
            //récupérer la description selon l'id
            $userDescription = $this->getUser()->getProfil()->getDescription();

            $users=$userRepository->findAll();

            //return des info récupérées
            return $this->render('Admin/profil.html.twig', [
                'Avatar'=>$userAvatar,
                'Description'=>$userDescription,
                'users'=>$users,
            ]);
        }

        /**
         * @route ("/admin/profilUpdate", name="AdminprofilUpdate")
         */
        public function profilUpdate(
            UserRepository $userRepository,
            SluggerInterface $slugger,
            ProfilRepository $profilRepository,
            EntityManagerInterface $entityManager,
            Request $request
        ){
            //récupération de l'id de l'utilisateur connecté
            $id = $this->getUser()->getId();
            //récupération des informations utilisateur selin l'id
            $user=$userRepository->find($id);
            //génération du formulaire
            $updateUserForm=$this->createForm(UserUpdateType::class, $user);
            $updateUserForm->handleRequest($request);

            //travail de l'avatar comme pour l'inscription
            if ($updateUserForm->isSubmitted() && $updateUserForm->isValid()){

                // je récupère l'image uploadée
                $userFormAvatar = $updateUserForm->get('profil')->get('Avatar')->getData();

                // s'il y a bien une image uploadée dans le formulaire
                if ($userFormAvatar){
                    //je récupère le nom de l'image
                    $originalAvatarName=pathinfo($userFormAvatar->getClientOriginalName(), PATHINFO_FILENAME);
                    //et grace a son nom original, je génère un nouveau qui sera unique
                    //pour éviter d'avoir des doublons de noms d'images en BDD
                    $safeAvatarName = $slugger->slug($originalAvatarName);
                    $uniqueAvatarName=$safeAvatarName.'-'.uniqid().'.'.$userFormAvatar->guessExtension();
                    //j'utilise un bloc try and catch
                    //qui agit comme une condition, mais si le bloc try échoue, ça soulève une erreur grace au catch
                    try {
                        // je prends l'image uploadée
                        // et je la déplace dans un dossier (dans public) + je la renomme avec
                        // le nom unique générée
                        // j'utilise un parametre (défini dans services.yaml) pour savoir
                        // dans quel dossier je la déplace
                        // un parametre = une sorte de variable globale
                        $userFormAvatar->move(
                            $this->getParameter('Avatar_directory'),
                            $uniqueAvatarName
                        );
                    }catch (FileException $e){
                        return new Response(($e->getMessage()));
                    }
                    //je sauvegarde dans la colonne  le nom de mon image
                    $user->getProfil()->setAvatar($uniqueAvatarName);
                }

                //... alors je persist et flush le nouvel utilisateur
                $entityManager->persist($user);
                $entityManager->flush();
                //Un message de remerciement
                $this->addFlash('success', 'votre profil a été mis à jour');
                return $this->redirectToRoute('profil');
            }

            return $this->render('Admin/profilUpdate.html.twig', [
                'updateUserForm'=>$updateUserForm->createView()
            ]);
        }


        /**
         * @route("/admin/delete_profil/{id}", name="Admindelete_profil")
         */
        public function delete_admin_author(
            UserRepository $userRepository,
            ProfilRepository $profilRepository,
            EntityManagerInterface $entityManager,
            $id
        )
        {
            //on récupère les informations du user gracge à l'id et on les stocke dans une variable
            $user=$userRepository->find($id);
            //on cherche le profil correspondant à l'id du user
            $profils=$this->getDoctrine()->getRepository(Profil::class)->ByUser($id);
            //on fait le tour des profils pour supprimer tout ce qui y correspond
            foreach ($profils as $profil){
                $entityManager->remove($profil);
            }
            //une fois le profil supprimer, on supprime le user
            $entityManager->remove($user);
            // on flush le tout
            $entityManager->flush();
            //on envoi un message de confirmation et on redirige vers une autre page
            $this->addFlash('success', 'Votre profil a été supprimé !');
            return $this->redirectToRoute('HomeAdmin');
        }

        /**
         * @route("/admin/profil/{id}", name="AdminprofilOtherUser")
         */
        public function profil_other_user(
            UserRepository $userRepository,
            DiscussionRepository $discussionRepository,
            $id
        ){

            //récupérer l'id de la personne voulu
            $user = $userRepository->find($id);
            //récupérer l'avatar selon l'id
            $userAvatar = $user->getProfil()->getAvatar();
            //récupérer la description selon l'id
            $userDescription = $user->getProfil()->getDescription();
            //récupérer les discussions que l'utilisateur à créé
            $discussion= $discussionRepository->findBy(array('user'=>$user));
            //return des info récupérées
            return $this->render('Admin/profilOtherUser.html.twig', [
                'User'=>$user,
                'discussions'=>$discussion,
                'Avatar'=>$userAvatar,
                'Description'=>$userDescription
            ]);
        }


    }

?>