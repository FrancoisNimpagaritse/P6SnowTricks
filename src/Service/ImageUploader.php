<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageUploader
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    public function upload($file) 
    {        
        //On récupère son ancien nom
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //On attribue un nouveau nom à l'image
        $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
        //On upload le fichier d'image à la destination paramétrée
        try {
            $file->move($this->params->get('upload_directory'), $newFilename);
        } catch (FileException $e) {
            throw new FileException('Une erreur est survenue: ' . $e->getMessage());
        }        
        
        return  $newFilename;
    }

    public function getParams()
    {
        return $this->params;
    }
}