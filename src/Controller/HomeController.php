<?php

    namespace App\Controller;


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


    }
?>