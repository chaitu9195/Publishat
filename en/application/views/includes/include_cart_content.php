              <?php foreach($cdata as $data){ 
               $label = $data['Notes'];
               $doc_path = $data['DocumentPath'];
               $filename = $data["filename"];
               $fid = $data["_id"];
               if(empty($filename)){
                     $filename =  pathinfo($doc_path, PATHINFO_FILENAME);
                      $filename =  substr(strstr($filename, "-"),1,15);
                }
                $filename = substr($filename, 0, 11);
                $ext = $data["FileType"];
              ?>
                 <tr>
                   <td class="col-xs-1"><input type="checkbox" name="document_id" id="doc_id" value="<?=$data['DocumentId']?>"></td>
                   <td class="col-xs-4"><?=$filename?></td>
                   <td class="col-xs-5"><a href="./viewfile?fid=<?=$data['DocumentId']?>" target="_blank" title ='View / Download File'><span class="files">
                    <?=get_icon(strtolower($ext));?> &nbsp; <?=$filename?>  </span></a>
                   </td>
                   <td class="col-xs-3"><?=$data['Path']?></td>
                 </tr>
              <?php } ?>




<?php 
function get_icon($ext){
               switch ($ext) {
                       case "jpeg":
                             echo '<i class="fa fa-file-image-o " aria-hidden="true"></i>';
                             break;
                       case "png":
                             echo '<i class="fa fa-file-image-o " aria-hidden="true"></i>';
                             break;
                       case "jpg":
                             echo '<i class="fa fa-file-image-o" aria-hidden="true"></i>';
                             break;
                       case "doc":
                             echo '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                             break;
                       case "docx":
                             echo '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
                             break;
                       case "pdf":
                             echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
                             break;
                       case "xls":
                             echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                             break;
                       case "xlsx":
                             echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
                             break;
                       case "ppt":
                             echo '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>';
                             break;
                       case "pptx":
                             echo '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>';
                             break;
                       case "txt":
                             echo '<i class="fa fa-file-text-o" aria-hidden="true"></i>';
                             break;
                       case "zip":
                             echo '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
                             break;
                       case "rar":
                             echo '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
                             break;
                      default:
                              echo '<i class="fa fa-file-file-o" aria-hidden="true"></i>';
                }

}


?>