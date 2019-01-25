<?php
    if ( !isset($_FILES['fileName']['error'] )) {
        echo '<b>Debes seleccionar un archivo antes de continuar</b>';
    }
    else {
        $hash=rand();
        $md5 = md5($hash);

        function compress($source, $destination, $quality) {

            $info = getimagesize($source);
        
            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);
        
            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);
        
            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);
        
            imagejpeg($image, $destination, $quality);
        
            return $destination;
        }
        $nimg = $_FILES['fileName']['name'];
        $ext = pathinfo($nimg, PATHINFO_EXTENSION);
        if($ext == 'jpg' or $ext == 'gif' or $ext == 'png'){
            $mes =date("m"); 
            $ano = date("Y");   
            $dia = date("d");  
            $source_img = $_FILES['fileName']['tmp_name'];
            $destination_img = getcwd()."../../../uploads/".$ano."/".$mes."/".$md5.$_FILES['fileName']['name'];
            
            $d = compress($source_img, $destination_img, 80);


            /* verificar tamaño de imagen actual */
            function getRemoteFileSize($url) {
                $info = get_headers($url,1);
         
                if (is_array($info['Content-Length'])) {
                    $info = end($info['Content-Length']);
                }
                else {
                    $info = $info['Content-Length'];
                }
         
                return $info;
            }
            /* transformador de bytes función */
            function convertToReadableSize($size){
                $base = log($size) / log(1024);
                $suffix = array("", "KB", "MB", "GB", "TB");
                $f_base = floor($base);
                return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
              }
            /* comprobando Protocolo*/
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
            /* aplicando función */
            $destinofinal = $protocol.$_SERVER['HTTP_HOST']."/wp-content/uploads/".$ano."/".$mes."/".$md5.$_FILES['fileName']['name'];
            $valorpuro = getRemoteFileSize($destinofinal);
            $valormoderado= convertToReadableSize($valorpuro);
            echo '<b>Tamaño comprimido:</b> <span style="color:green; font-weight:700;">'.$valormoderado.'</span><br><br>';
            echo '<b>Url generada:</b> <input type="text" value='.$destinofinal.' size="50px" readonly onclick="copiarAlPortapapeles(\''.$destinofinal.'\')"/><div id="flashbagUpload"></div>';
            echo "<br><br><b class='mensaje-upload'>Copia el enlace y pegalo en Featured Image by URL en la parte inferior derecha</b>";
        }else{
            echo "<b>Enxtensión de archivo incorrecta, sube solo imagenes con extensión (png, jpg, gif)</b>";
        }
            
    }

?>
<script>
        function copiarAlPortapapeles(id_elemento) {


        $("#flashbagUpload").html("Copiado al Portapapeles!");   
        $("#flashbagUpload").fadeOut(1500);
        // Crea un campo de texto "oculto"
        var aux = document.createElement("input");

        // Asigna el contenido del elemento especificado al valor del campo

        aux.setAttribute("id", "copiarTextoUpload");
        aux.setAttribute("value", id_elemento);

        // Añade el campo a la página
        document.body.appendChild(aux);

        // Selecciona el contenido del campo
        aux.select();

        // Copia el texto seleccionado
        document.execCommand("copy");

        // Elimina el campo de la página
        document.body.removeChild(aux);

    }
</script>