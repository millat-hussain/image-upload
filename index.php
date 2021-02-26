<?php 

include "config/config.php";
include "lab/Database.php";

$db =new Database();

 ?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Image Upload Bast Waya</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>

    	<?php 

    	if (isset($_FILES['fileupload'])) {


    		$imgtype = array('jpg','png','jpeg','gif');

    	    $filename =$_FILES['fileupload']['name'];
    		$filesize =$_FILES['fileupload']['size'];
    		$tmp_name =$_FILES['fileupload']['tmp_name'];

            // Uniqe image name genarator;
            $div =explode(" . ", $filename);
            $file_ext =strtolower(end($div));
            $uniq_image = substr(md5(time()), 0,5).'.'.$file_ext;
            $upload_image = "upload/".$uniq_image;
             // Uniqe image name genarator;
             // Image Validation start

            if (empty($filename)) {
                echo "Fild Must Be Empty";

            }elseif ($filesize > 1048576*10) {
               echo "Image Size should > 1 MB";}
            // }elseif (in_array($file_ext , $imgtype)===false) {
            //     echo "Youcan Upload Only".implode(" , ",  $imgtype);
            // }
               else { 
           
             // Image Validation start

            // Upload image file to Database
            move_uploaded_file($tmp_name , $upload_image);

    		$query ="INSERT INTO tbl_user_image (image) VALUES ('$upload_image')";
            $rasult=$db->insert($query);
            if ($rasult==true) {
                echo "image upload successfully";
                
            }else{
                echo "Sorry Some Problem";
             // Upload image file to Database
            }
             }
    
    
    		}


    	 ?>

    	<form method="POST" action="" enctype="multipart/form-data">

    		<h2>Image & File Upload</h2>

    		<input type="file" name="fileupload">
    		<br>
    		<input type="submit" name="upload" value="Upload image">

            <?php 
            if (isset($_GET['imid'])) {
                $id = $_GET['imid'];
            }else{
                echo "Wrong Information";
            }

            // image unlink 
              $unlink ="SELECT * FROM tbl_user_image WHERE id='$id'";
              $unlk = $db->select($unlink);
              if ($unlk) {
                 while ($unlinkimg = $unlk->fetch_assoc()) {

                    $undelimag = $unlinkimg["image"];
                    unlink($undelimag);}

                     
              }


            // image unlink 


            $delimage ="DELETE FROM tbl_user_image WHERE id='$id'";
            $delimage = $db->delete($delimage);

            if ($delimage==true) {
                echo "Yes Your Image Deletead successfully";
               
            }



             ?>



            <table border="1px solid" style="    width: 100%;
                text-align: center;
                font-family: arial;
                margin-top: 1rem;">
              <thead>
                  <tr>
                      <th>Serial NO : </th>
                      <th>Image : </th>
                      <th>Action : </th>
                  </tr>
              </thead>

              <?php 
              $show ="SELECT * FROM tbl_user_image";
              $showimg = $db->select($show);
              if ($showimg) {
                $i=0;
                 while ($showimgtbl =  $showimg->fetch_assoc()) {
                    $i++;
               ?>
              <tbody>
                  <tr>
                      <td><?php echo $i; ?></td>
                      <td><img src="<?php echo $showimgtbl['image'] ?>" width="150px"></td>
                      <td><a href="?imid=<?php echo $showimgtbl['id'] ?>">Delete</a></td>
                  </tr>
              </tbody>
          <?php }} ?>
            </table>

    </body>
</html>