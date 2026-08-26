<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles_images_model extends CI_Model {

        function articleimage(){  
                        $image = $_FILES["upload_file"]; 
			$imageName = $_FILES["upload_file"]["name"];
                        if(!empty($imageName)){  
			   $tmp_path = $_FILES['upload_file']['tmp_name'];
                           $article_image_folder = "../../articleImages";		
			   $image_filename = date("YmdHis") . "-" .  str_replace(" ", "-", $imageName);
			   $target_file_name = $article_image_folder . "/" . $image_filename;
			   $moveResult = move_uploaded_file($tmp_path, $target_file_name);
                           $image_path = str_replace("../../","",$image_filename);
                           $image_full_path = "https://www.publishat.com/articleImages/".$image_path;
                        }
                        else{
                           $image_full_path = '';
                        }  
              return array("path"=>$image_full_path);                      
                        
            
      }


}
