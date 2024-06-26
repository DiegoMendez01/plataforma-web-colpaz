<?php

require_once("../models/Contents.php");

class ContentController
{
    private $contentModel;

    public function __construct()
    {
        $this->contentModel = new Contents();
    }

    public function handleRequest()
    {
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['title'], $_POST['description'], $_POST['header_content_id'], $_FILES['file'], $_POST['video']);
                }else{
                    $this->update($_POST['id'], $_POST['title'], $_POST['description'], $_POST['header_content_id'], $_FILES['file'], $_POST['video']);
                }
                break;
            case "delete":
                $this->delete($_POST['id']);
                break;
            case "show":
                $this->show($_POST['id']);
                break;
            case "disabled":
                $this->disabled($_POST['id']);
                break;
            case "enabled":
                $this->enabled($_POST['id']);
                break;
        }
    }

    private function create($title, $description, $header_content_id, $file, $video = null)
    {
        if(empty($title) OR empty($description) OR empty($file) OR empty($header_content_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            
            // Files
            $material      = $_FILES['file']['name'];
            $url_temp      = $_FILES['file']['tmp_name'];
            
            $dir         = '../docs/contents/'.rand(1000, 10000);
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
                $status = $this->contentModel->insertContent($title, $description, $header_content_id, $file, $video, $destiny, $url_temp);
                if($status){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Se ha creado correctamente el contenido'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $title, $description, $header_content_id, $file, $video = null)
    {
        if(empty($title) OR empty($description) OR empty($file) OR empty($header_content_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            
            // Files
            $material      = $_FILES['file']['name'];
            $url_temp      = $_FILES['file']['tmp_name'];
            
            $dir         = '../docs/contents/'.rand(1000, 10000);
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
                $status = $this->contentModel->updateContent($id, $title, $description, $header_content_id, $file, $video, $destiny, $url_temp);
                if($status){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Se ha creado correctamente el curso'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function delete($id)
    {
        $this->contentModel->deleteContentById($id);
    }

    private function show($id)
    {
        $contents = $this->contentModel->getContentById($id);
        echo json_encode($contents);
    }

    private function disabled($id)
    {
        $this->contentModel->disabledContent($id);
    }

    private function enabled($id)
    {
        $this->contentModel->enabledContent($id);
    }
}

$controller = new ContentController();
$controller->handleRequest();
