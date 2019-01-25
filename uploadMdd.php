<?php
/**
 * Plugin Name: Image Compress Fw
 * Plugin URI: #
 * Description: Sube y a la vez comprime la calidad de imagen
 * Version: 1.5.0
 * Author: Ariel Burgos
 * Author URI: https://blogueroinformatico.com
 * Requires at least: 4.0
 * Tested up to: 5.0
 *
 * Text Domain: image-compress
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) or die( 'Prohibido XD' );


function upload_form(){
    ?>
    <style type="text/css">
        /* Soundpress Modal (background) */
        .uploadmodal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        
        /* Soundpress Modal Content/Box */
        .uploadmodal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            max-width: 450px;
            width: 70%; /* Could be more or less, depending on screen size */
            border-bottom: 10px solid #008ed2;
        }
        
        /* The Close Button */
        .uploadmodal-close {
            color: #ffffff;
            float: right;
            font-size: 13px;
            font-weight: bold;
            margin-top: -15px;
            margin-right: -15px;
            background-color: #716b6b;
            border-radius: 50%;
            padding-left: 4px;
            padding-right: 4px;
            }
        
        .uploadmodal-close:hover,
        .uploadmodal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        input#upload_txt {
        display: none;
        }
        label.selecciona-imgcompress {
            margin: 0 auto;
            display: block;
            text-align: center;
            font-size: 13px;
            padding: 5px;
            border: 1px solid #ccc;
            box-shadow: 0px 2px 9px 3px #2b29291c;
        }

        .contenedor-btn-subir {
            width: 100%;
            display: block;
            margin: 0 auto;
            text-align: center;
        }
        div#rutanueva input {
            margin-top: 15px;
        }
        div#loading-upload {
                text-align: center;
            }

        div#descripccion-upload {
            text-align: left;
            margin-top: 10px;
        }
        b.mensaje-upload {
            color: green;
        }
        div#rutanueva input {
            margin-top: 15px;
            border-radius: 10px;
            padding: 5px;
        }
        div#flashbagUpload {
            font-size: 15px;
            font-weight: 700;
            color: #f38d10;
            text-align: center;
            margin-top: 15px;
        }
        span.dashicons.dashicons-format-image {
                vertical-align: middle;
            }
    </style>
    <p>
        <label for="upload_txt" class="selecciona-imgcompress"><span class="dashicons dashicons-camera"></span>Seleccionar Imagen</label><br />
        <input id="upload_txt" name="upload_txt" style="width:80%" type="file" value="Examinar" />
        <div class="contenedor-btn-subir">
            <a href="#" id="subir_img" class="button">Subir y Comprimir</a>
            <div id="descripccion-upload"></div>
        </div>
        
        <div id="rutanueva"></div>
    </p>
        
    <script>

        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return 'n/a';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            if (i == 0) return bytes + ' ' + sizes[i];
            return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
        };
        $("#upload_txt").on("change", function(){
        if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/) ) {
              
                var fileName = this.files[0].name;
                var fileSize = this.files[0].size;
                var tamano = bytesToSize(fileSize);
                $("#descripccion-upload").html("<b>Información de la Imagen:</b> <br><b>Tamaño actual:</b> " + tamano);
        }
        else{
            $("#descripccion-upload").html("<b style='color:red'>Atención:</b> El archivo seleccionado no es una imagen, solo se admiten imagenes (png, jpg, gif)");
        }
        });
    </script>
    <?php
}


function add_upload_button(){
    ?>
 <div id="upload-form" class="uploadmodal" >
        <div class="uploadmodal-content">
            <span class="uploadmodal-close">X</span>
            <?php upload_form(); ?>
            <a href="#" id="uploadmodal-finalizar" class="button"> Cerrar  </a>     
        </div>
</div>
<a href="#" id="insert-upload" class="button"><span class="dashicons dashicons-format-image"></span><span> Comprimir Imagen</span></a>
    <?php
}

add_action('media_buttons', 'add_upload_button', 15);



add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "my_voter_script", WP_PLUGIN_URL.'/ImageCompressFw/uploadmdd.js', array('jquery') );
   wp_localize_script( 'my_voter_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'my_voter_script' );

}








    