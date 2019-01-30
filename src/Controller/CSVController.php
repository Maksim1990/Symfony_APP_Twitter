<?php

namespace App\Controller;

use App\Entity\MicroPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;

class CSVController extends Controller
{
    /**
     * @Route("/csv/export", name="csv_export")
     */
    public function export()
    {
        $posts = $this->getDoctrine()->getRepository(MicroPost::class)->findAllToArray();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $em         = $this->getDoctrine()->getManager();
        $arrColumns = $em->getClassMetadata('App\Entity\MicroPost')->getColumnNames();

        $csv->insertOne($arrColumns);

        foreach ($posts as $post) {
            $post['time']= $post['time']->format('Y-m-d H:i:s');
            $csv->insertOne($post);
        }

         $csv->output('post.csv');

        die;
    }


    /**
     * @Route("/csv/import", name="csv_import")
     */
    public function import()
    {
        $reader = \League\Csv\Reader::createFromPath($this->get('kernel')->getProjectDir().'/data/post.csv', 'r');
        $reader->setHeaderOffset(0);

        //-- Get header column names
        $header = $reader->getHeader();

        $records = $reader->getRecords();
        $arrData=array();

        $em = $this->getDoctrine()->getManager();
        foreach ($records as $offset => $record) {
            $arrData[]=$record;

            $microPost = new MicroPost();
            foreach ($record as $key => $strVal) {

                if($key=="text"){
                    $microPost->setText($strVal);
                }
                if($key=="time") {
                    $date = new \DateTime($strVal);
                    $microPost->setTime($date);
                }
            }
            $microPost->setUser($this->getUser());
            $em->persist($microPost);

        }
        $em->flush();


        return $this->redirectToRoute('micro_post_index');
    }


}
