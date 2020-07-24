<?php

    namespace App\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;

    class AdminController extends AbstractController{

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx HOME xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin", name="HomeAdmin")
         */
        public function Home(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminHome.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx COURSE xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/parcours", name="CourseAdmin")
         */
        public function Course(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminCourse.html.twig');
        }

        /**
         * @route ("/admin/parcours/discussions", name="CourseDiscussionAdmin")
         */
        public function CourseDiscussion(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminCourse_Discussion.html.twig');
        }


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx PLACES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/lieux", name="PlacesAdmin")
         */
        public function Places(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminPlaces.html.twig');
        }

        /**
         * @route ("/admin/lieux/discussions", name="PlacesDiscussionAdmin")
         */
        public function PlacesDiscussion(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminPlaces_Discussion.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ACTIVITIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/activitées", name="ActivitiesAdmin")
         */
        public function Activities(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminActivities.html.twig');
        }

        /**
         * @route ("/admin/activitées/discussions", name="ActivitiesDiscussionAdmin")
         */
        public function ActivitiesDiscussion(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminActivities_Discussion.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx GALERIES xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/galeries", name="GaleriesAdmin")
         */
        public function Galeries(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminGaleries.html.twig');
        }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx LES POST xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/postTitle", name="postAdmin")
         */
        public function post(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminPost.html.twig');
        }

        /**
         * @route ("/admin/imagesTitle", name="imagesAdmin")
         */
        public function images(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminAlbum.html.twig');
        }

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx LES POST xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/recherche", name="searchAdmin")
         */
        public function search(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminSearch.html.twig');
        }


        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Les formalitées xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        /**
         * @route ("/admin/formalité", name="formaliteesAdmin")
         */
        public function formalitees(){
            //var_dump('hello world');
            //die;
            return $this->render('Admin/AdminFormalitees.html.twig');
        }


    }

?>