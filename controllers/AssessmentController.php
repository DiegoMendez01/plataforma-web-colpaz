<?php

require_once("../models/Assessments.php");
require_once("../docs/Session.php");

class AssesmentController
{
    private $assessmentModel;
    private $session;

    public function __construct()
    {
        $this->assessmentModel = new Assessments();
        $this->session         = Session::getInstance();
    }

    public function handleRequest()
    {
        $idr = $this->session->get('idr');
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['title'], $_POST['comment'], $_POST['percentage'], $_POST['content_id'], $_FILES['file'], $_POST['date_limit'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['title'], $_POST['comment'], $_POST['percentage'], $_POST['content_id'], $_FILES['file'], $_POST['date_limit'], $idr);
                }
                break;
            case "delete":
                $this->delete($_POST['id'], $idr);
                break;
            case "show":
                $this->show($_POST['id'], $idr);
                break;
        }
    }

    private function create($title, $comment, $percentage, $content_id, $file, $date_limit, $idr)
    {
        if(empty($title) OR empty($comment) OR empty($percentage) OR empty($file) OR empty($content_id) OR empty($date_limit)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            // Files
            $material      = $_FILES['file']['name'];
            $url_temp      = $_FILES['file']['tmp_name'];
            
            $dir         = '../docs/activities/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;

            if($_FILES['file']['size'] > 15000000){
                $answer = [
                    'status' => false,
                    'msg'    => 'Solo se permiten archivos hasta 15MB'
                ];
            }else{
                $status = $this->assessmentModel->insertAssessment($title, $comment, $percentage, $content_id, $file, $date_limit, $url_temp, $destiny, $idr);
                if($status){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Se ha creado correctamente la actividad'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $title, $comment, $percentage, $content_id, $file, $date_limit, $idr)
    {
        if(empty($title) OR empty($comment) OR empty($percentage) OR empty($file) OR empty($content_id) OR empty($date_limit)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            // Files
            $material      = $_FILES['file']['name'];
            $url_temp      = $_FILES['file']['tmp_name'];
            
            $dir         = '../docs/activities/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;

            if($_FILES['file']['size'] > 15000000){
                $answer = [
                    'status' => false,
                    'msg'    => 'Solo se permiten archivos hasta 15MB'
                ];
            }else{
                $status = $this->assessmentModel->updateAssessment($id, $title, $comment, $percentage, $content_id, $file, $date_limit, $url_temp, $destiny, $idr);
                if($status){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Se ha actualizado correctamente la actividad'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function delete($id, $idr)
    {
        $this->assessmentModel->deleteAssessmentById($id, $idr);
    }

    private function show($id, $idr)
    {
        $assessment = $this->assessmentModel->getAssessmentById($id, $idr);
        echo json_encode($assessment);
    }
}

$controller = new AssesmentController();
$controller->handleRequest();
