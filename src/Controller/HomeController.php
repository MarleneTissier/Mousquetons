<?php

    namespace App\Controller;


    use App\Entity\Galerie;
    use App\Entity\Image;
    use App\Entity\Profil;
    use App\Entity\User;
    use App\Form\GalerieType;
    use App\Form\PostType;
    use App\Form\ProfilType;
    use App\Form\UserType;
    use App\Repository\GalerieRepository;
    use App\Repository\PostRepository;
    use App\Repository\ProfilRepository;
    use App\Repository\UserRepository;
    use App\Form\DiscussionType;
    use App\Repository\DiscussionRepository;
    use App\Entity\Post;
    use App\Entity\Discussion;
    use Doctrine\ORM\EntityManagerInterface;
    use Doctrine\Common\Collections\ArrayCollection;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\String\Slugger\SluggerInterface;
    use Symfony\Component\Security\Core\User\UserInterface;

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
            $lieux = $discussionRepository ->findBy(['categorie'=>'2'], ['id'=>'DESC'], 3);
            $activites = $discussionRepository ->findBy(['categorie'=>'3'], ['id'=>'DESC'], 3);

            return $this->render('Home.html.twig', [
                'parcours' => $parcours,
                'lieux'=> $lieux,
                'activites' => $activites,
                'users'=>$users
            ]);
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx COURSE xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/parcours", name="Course")
         */
        public function Course(DiscussionRepository $discussionRepository){
            //var_dump('hello world');
            //die;

            $parcoursFrance = $discussionRepository ->findBy(array('categorie'=>'1', 'place'=>'1'), ['id'=>'DESC']);
            $parcoursEspagne = $discussionRepository ->findBy(array('categorie'=>'1', 'place'=>'2'), ['id'=>'DESC']);
            $parcoursEurope = $discussionRepository ->findBy(array('categorie'=>'1', 'place'=>'3'), ['id'=>'DESC']);
            $parcoursMonde = $discussionRepository ->findBy(array('categorie'=>'1', 'place'=>'4'), ['id'=>'DESC']);
            return $this->render('Course.html.twig', [
                'parcoursFrance' => $parcoursFrance,
                'parcoursEspagne' => $parcoursEspagne,
                'parcoursEurope' => $parcoursEurope,
                'parcoursMonde' => $parcoursMonde
            ]);
        }

        /**
         * @route ("/parcours/discussions/{id}", name="CourseDiscussion")
         */
        public function CourseDiscussion(DiscussionRepository $discussionRepository, $id){
            //var_dump('hello world');
            //die;
            $parcours = $discussionRepository ->findBy(array('categorie'=>'1', 'place'=>$id), ['id'=>'DESC']);
            return $this->render('Course_Discussion.html.twig', [
                'parcours' => $parcours
            ]);
        }


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx PLACES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/lieux", name="Places")
         */
        public function Places(DiscussionRepository $discussionRepository){
            //var_dump('hello world');
            //die;
            $lieuxFrance = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'1'), ['id'=>'DESC']);
            $lieuxEspagne = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'2'), ['id'=>'DESC']);
            $lieuxEurope = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'3'), ['id'=>'DESC']);
            $lieuxMonde = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>'4'), ['id'=>'DESC']);
            return $this->render('Places.html.twig',[
                'lieuxFrance'=> $lieuxFrance,
                'lieuxEspagne'=> $lieuxEspagne,
                'lieuxEurope'=> $lieuxEurope,
                'lieuxMonde'=> $lieuxMonde
            ]);
        }

        /**
         * @route ("/lieux/discussions/{id}", name="PlacesDiscussion")
         */
        public function PlacesDiscussion(DiscussionRepository $discussionRepository, $id){
            //var_dump('hello world');
            //die;
            $lieux = $discussionRepository ->findBy(array('categorie'=>'2', 'place'=>$id), ['id'=>'DESC']);
            return $this->render('Places_Discussion.html.twig',[
                'lieux'=> $lieux
            ]);
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ACTIVITIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/activitées", name="Activities")
         */
        public function Activities(DiscussionRepository $discussionRepository){
            //var_dump('hello world');
            //die;
            $activitesFrance = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'1'), ['id'=>'DESC']);
            $activitesEspagne = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'2'), ['id'=>'DESC']);
            $activitesEurope = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'3'), ['id'=>'DESC']);
            $activitesMonde = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>'4'), ['id'=>'DESC']);
            return $this->render('Activities.html.twig',[
                'activitesFrance'=> $activitesFrance,
                'activitesEspagne'=> $activitesEspagne,
                'activitesEurope'=> $activitesEurope,
                'activitesMonde'=> $activitesMonde
            ]);
        }

        /**
         * @route ("/activitées/discussions/{id}", name="ActivitiesDiscussion")
         */
        public function ActivitiesDiscussion(DiscussionRepository $discussionRepository, $id){
            //var_dump('hello world');
            //die;
            $activites = $discussionRepository ->findBy(array('categorie'=>'3', 'place'=>$id), ['id'=>'DESC']);

            return $this->render('Activities_Discussion.html.twig',[
                'activites'=>$activites
            ]);
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
         * @route ("/postTitle/{id}", name="post")
         */
        public function Post(DiscussionRepository $discussionRepository,
                             PostRepository $postRepository,
                             EntityManagerInterface $entityManager,
                             UserRepository $userRepository,
                             Request $request,
                             ?UserInterface $user,
                             $id){
            //dump('hello world');
            //die;
            $discussion = $discussionRepository->find($id);
            $discussionID = $discussionRepository->find($id);
            $discussionPosts= $postRepository->findBy(array('discussion'=>$id));
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
                    return $this->redirectToRoute('post', array('id' => $id));
                }
            }


            return $this->render('Post.html.twig', [
                'discussion'=>$discussion,
                'discussionPosts'=>$discussionPosts,
                'postForm' => $PostForm->createView()
            ]);
        }

        /**
         * @route ("/imagesTitle", name="images")
         */
        public function images(){
            //var_dump('hello world');
            //die;
            return $this->render('Album.html.twig');
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx La recherche xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/recherche", name="search")
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
            return $this->render('Search.html.twig', [
                'discussions'=>$discussion
            ]);
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
        public function profil(
            UserRepository $userRepository,
            ProfilRepository $profilRepository,
            DiscussionRepository $discussionRepository
        ){
            //var_dump('hello world');
            //die;
            $id = $this->getUser()->getId();
            $userID = $userRepository->find($id);
            $userAvatar = $this->getUser()->getProfil()->getAvatar();
            $userDescription = $this->getUser()->getProfil()->getDescription();
            $discussion= $discussionRepository->findBy(array('user'=>$userID));
            return $this->render('profil.html.twig', [
                'discussions'=>$discussion,
                'Avatar'=>$userAvatar,
                'Description'=>$userDescription
            ]);
        }



        /**
         * @route ("/profilUpdate", name="profilUpdate")
         */
        public function profilUpdate(
            UserRepository $userRepository,
            SluggerInterface $slugger,
            EntityManagerInterface $entityManager,
            Request $request
        ){
            //dump('hello world');
            //die;
            $id = $this->getUser()->getId();
            $userID = $userRepository->find($id);
            $user=$userRepository->find($userID);

            $updateUserForm=$this->createForm(ProfilType::class, $user);
            $updateUserForm->handleRequest($request);

            if ($updateUserForm->isSubmitted() && $updateUserForm->isValid()){

                // je récupère l'image uploadée
                $userFormAvatar = $updateUserForm->get('avatar')->getData();

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
                    //je sauvegarde dans la colonne bookCover le nom de mon image
                    $user->setAvatar($uniqueAvatarName);
                }

                //... alors je persist et flush le nouvel utilisateur
                $entityManager->persist($user);
                $entityManager->flush();
                //Un message de remerciement
                $this->addFlash('success', 'votre profil a été mis à jour');
                return $this->redirectToRoute('profil');
            }


            return $this->render('profilUpdate.html.twig', [
                'updateUserForm'=>$updateUserForm->createView()
            ]);
        }






        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx inscription xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//https://symfonycasts.com/screencast/symfony-forms/registration-form

        /**
         * @route("/inscription", name="inscription")
         */
        public function inscription(
            Request $request,
            EntityManagerInterface $entityManager,
            UserPasswordEncoderInterface $passwordEncoder,
            SluggerInterface $slugger
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
                //encoder le mot de passe :
                $user = $userForm->getData();
                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                ));
                // je récupère l'image uploadée
                $userFormAvatar = $userForm->get('profil')->get('Avatar')->getData();
                //la j'ai laisser $userFormAvatar qui récupère seulement 'profil' car je n'ai pas encore trouvé
                //comment récupérer seulement "Avatar' qui se trouve dans 'profil'
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
                        // et je la déplace dans un dossier et je la renomme avec le nom unique générée
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
         * @route ("/test", name="test")
         */
        public function test(){
            $id = $this->getUser()->getId();
            var_dump($id);
            die;
        }


        /**
         * @route ("/formulaireDicussion", name="formulaireDicussion")
         */
        public function formulaireDicussion(
            Request $request,
            EntityManagerInterface $entityManager,
            UserRepository $userRepository
        )
        {
            //var_dump('hello world');
            //die;
            $id = $this->getUser()->getId();
            $userID = $userRepository->find($id);
            $discussion = new Discussion();
            $discussionForm=$this->createForm(DiscussionType::class, $discussion);
            $discussionForm->handleRequest($request);

            if ($discussionForm->isSubmitted()&&$discussionForm->isValid()){
                $discussion->setUser($userID);
                $discussion->setNmbPost(0);
                $discussion->setDate(new \DateTime('now'));
                $entityManager->persist($discussion);
                $entityManager->flush();
                $this->addFlash('success', 'Votre Discussion a bien été crée !');
                return $this->redirectToRoute('profil');
            }
            return $this->render('formulaireDiscussion.html.twig', [
                'discussionForm'=>$discussionForm->createView()
            ]);
        }



        /**
         * @route ("/formulaireGalerie", name="formulaireGalerie")
         */
        public function formulaireGalerie(
            UserRepository $userRepository,
            GalerieRepository $galerieRepository,
            EntityManagerInterface $entityManager,
            SluggerInterface $slugger,
            Request $request
        ){
            //var_dump('hello world');
            //die;
            //trouver l'id correspondant à l'utilisateur qui souhaite créer la galerie
            $id = $this->getUser()->getId();
            $userID = $userRepository->find($id);
            //créatio du formulaire
            $galerie = new Galerie();
            $image = new Image();

            $originalImages = new ArrayCollection();

            // Create an ArrayCollection of the current Tag objects in the database
            foreach ($galerie->getImages() as $image) {
                $originalImages->add($image);
            }

            $galerieForm=$this->createForm(GalerieType::class, $galerie);
            $galerieForm->handleRequest($request);
            //on vérifie si les valeurs entrées par l'utilisateur sont correctes :
            if ($galerieForm->isSubmitted()&&$galerieForm->isValid()){

                // supprimer la relation entre la balise et la tâche
                foreach ($originalImages as $image) {
                    if (false === $galerie->getTags()->contains($image)) {
                        // supprime l'image de la galerie
                        $image->getTasks()->removeElement($image);

                        $entityManager->persist($image);
                    }
                }

                // on vérifie s'il y a une/des images
                $imageUpload = $galerieForm->get('images')->get('picture')->getData();
                // s'il y a bien une image uploadée dans le formulaire
                if ($imageUpload){
                    //je récupère le nom de l'image
                    $originalPictureName=pathinfo($imageUpload->getClientOriginalName(), PATHINFO_FILENAME);
                    //et grace a son nom original, je génère un nouveau qui sera unique
                    $safePictureName = $slugger->slug($originalPictureName);
                    $uniquePictureName=$safePictureName.'-'.uniqid().'.'.$imageUpload->guessExtension();
                    //j'utilise un bloc try and catch qui agit comme une condition
                    try {
                        // je prends l'image uploadée et je la déplace dans un dossier (dans public)
                        $imageUpload->move(
                            $this->getParameter('book_cover_directory'),
                            $uniquePictureName
                        );
                    }catch (FileException $e){
                        return new Response(($e->getMessage()));
                    }
                    //je sauvegarde le nom de mon image
                    $galerie->getImage()->setPicture($uniquePictureName);
                }
                //on ajoute l'id de l'utilisateur dans la galerie
                $galerie->setUser($userID);
                // on persist et on flush
                $entityManager->persist($galerie);
                $entityManager->flush();
                $this->addFlash('success', 'Votre Discussion a bien été crée !');
                //retour à la page profil
                return $this->redirectToRoute('profil');
            }
            //on affiche la page du formulaire
            return $this->render('formulaireGalerie.html.twig', [
                'galerieForm'=>$galerieForm->createView()
            ]);
        }





    }

?>