<?php
$host_aceptados = array('localhost', '127.0.0.1');
$metodo_aceptados = 'POST';
$usuario_correcto = 'Admin';
$password_correcto = 'Admin';

$txt_usuario = $_POST["txt_usuario"];
$txt_password = $_POST["txt_password"];
$token = "";

if(in_array($_SERVER["HTTP_HOST"],$host_aceptados)){
    //La direcci[o]n ip es aceptada
    if($_SERVER["REQUEST_METHOD"] == $metodo_aceptados){
        //Se acepta el m[e]todo usado por el usuario
        if(isset($txt_usuario) && !empty($txt_usuario)){
            //Se enviaron los valores al campo usuario
            if(isset($txt_password) && !empty($txt_password)){
                //Se enviaron los valores al campo password
                if($txt_usuario==$usuario_correcto){
                    //El valor ingresado en el campo usuario es correcto
                    if($txt_password==$password_correcto){
                        //El valor ingresado en el campo password es correcto
                        $ruta = "welcome.php";
                        $msg = "";
                        $codigo_estado = 200;
                        $texto_estado = "ok";

                        list($usec,$sec) = explode(' ',microtime());

                        $token = base64_encode(date("Y-m-d H:i:s",$sec).substr($usec, 1));
                    }else{
                        //El valor ingresado en el campo password no es correcto
                        $ruta = "";
                        $msg = "SU CONTRASE[N]A ES INCORRECTA";
                        $codigo_estado = 400;
                        $texto_estado = "Bad Request";

                        $token = "";
                    }
                }else{
                    //El valor ingresado en el campo usuario no es correcto
                    $ruta = "";
                    $msg = "NO SE RECONOCE EL USUARIO DIGITADO";
                    $codigo_estado = 401;
                    $texto_estado = "Unauthorized";

                    $token = "";
                }
            }else{
                //No se enviaron los valores al campo password
                $ruta = "";
                $msg = "EL CAMPO PASSWORD EST[A] VAC[I]O";
                $codigo_estado = 401;
                $texto_estado = "Unauthorized";

                $token = "";
            }
        }else{
            //No se enviaron los valores al campo usuario
            $ruta = "";
            $msg = "EL CAMPO USUARIO EST[A] VAC[I]O";
            $codigo_estado = 401;
            $texto_estado = "Unauthorized";

            $token = "";
        }
    }else{
        //No se acepta el m[e]todo usado por el usuario
        $ruta = "";
        $msg = "EL M[E]TODO USADO NO ES ACEPTADO";
        $codigo_estado = 405;
        $texto_estado = "Method Not Allowed";

        $token = "";
    }
}else{
    //La direcci[o]n ip no es aceptada
    $ruta = "";
    $msg = "SU EQUIPO NO EST[A] AUTORIZADO PARA REALIZAR LA PETICI[O]N";
    $codigo_estado = 403;
    $texto_estado = "Forbidden";

    $token = "";
}


$arreglo_respuesta = array(
    "status" => ((intval($codigo_estado)==200) ? "Ok": "Error"),
    "error" => ((intval($codigo_estado)==200) ? "": array("code" => $codigo_estado,"message" => $msg)),
    "data" => array(
        "url" => $ruta,
        "token" => $token
    ),
    "count" => 1

);

header("HTTP/1.1 ".$codigo_estado." ".$texto_estado);
header("Content-Type: Application/json");
echo(json_encode($arreglo_respuesta));


?>
