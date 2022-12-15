    <?php

        define('UPLOAD_DIR',  '/var/uploaded_files/');
        define('MAXSIZE', 7340032); // allow max 7 MB

        $ALLOWED_MIME = array('text/comma-separated-values', 'text/csv', 'text/plain',
	    'application/csv', 'application/excel',
	    'application/vnd.ms-excel', 'application/vnd.msexcel');

        // Handling Error
        if (!empty($_FILES)) {
            echo $error = $_FILES['file']['error'];
            switch($error) {
                case UPLOAD_ERR_OK:
                $response = handleUpload();
                break;
                case UPLOAD_ERR_INI_SIZE:
                $response = 'Error: file size exceeds the allowed.';
                break;
                default:
                $response = 'An unexpected error occurred; the file could not be uploaded.';
                break;
            }
        } else {
            $response = 'Please upload CSV file';
        }
        echo $response;					
                    
        // allowed file extension		

        function allowedfile($tempfile, $destpath) {
            global $ALLOWED_MIME;
            $file_ext = pathinfo($destpath, PATHINFO_EXTENSION); 
            $file_mime = mime_content_type($tempfile);
            $valid_mime = in_array($file_mime, $ALLOWED_MIME);
            $allowed_file = ($file_ext == 'csv') && $valid_mime;
            return $allowed_file;
        }

        function handleUpload() {
            $temp = $_FILES['file']['tmp_name'];
            $filename = basename($_FILES['file']['name']);
            $file_dest = UPLOAD_DIR. $filename;
            $is_uploaded = is_uploaded_file($temp); 
            $valid_size = $_FILES['file']['size'] <= MAXSIZE && $_FILES['file']['size'] >= 0;
               
            if ($is_uploaded && $valid_size && allowedfile($temp, $file_dest)) {
                move_uploaded_file($temp, $file_dest);
                insertCSV($file_dest);
            } else {
                $response = 'Error: uploaded file size or type is not valid.';
            }
            return $response;
        }

        function insertCSV($filename){ 
            $conn = mysqli_connect('hostname', 'username', 'password', 'database');
            //Check for connection error
            if($conn->connect_error){
              die("Error in DB connection: ".$conn->connect_errno." : ".$conn->connect_error);    
            }
            if($fileHandle = fopen($filename, "r")){
             while(($row = fgetcsv($fileHandle, 0, ",")) !== FALSE)
             {
              $insert = "INSERT into empdata(name,email,phone) values('$row[0]','$row[1]','$row[2]')";
              if(mysqli_query($conn, $insert)){
               echo 'Data inserted successfully';
              }
              else{
               echo 'Error: '.mysqli_error($conn);
              }
             }
             fclose($fileHandle);
              echo "CSV File has been successfully Imported.";
            }
        }
            
           
        
    ?>

