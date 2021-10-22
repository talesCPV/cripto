<!DOCTYPE html>
<html>
<head>
	<title>Files</title>
</head>
<body>

    <div style="margin: 20px;">

        <!-- O tipo de encoding de dados, enctype, DEVE ser especificado abaixo -->
        <form enctype="multipart/form-data" action="#" method="POST" >
            <!-- MAX_FILE_SIZE deve preceder o campo input -->
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <!-- O Nome do elemento input determina o nome da array $_FILES -->
            Upload de arquivo: <input name="userfile" type="file" />
            <input type="submit" value="Enviar arquivo" />
        </form>
        <hr/>

        <form name="frmFileOpen" id="frmFileOpen" action="#" method="POST">

            <?php

                $path = "files/";
                $diretorio = dir($path);

                echo "Lista de arquivos '<strong>".$path."</strong>':<br/>
                <select name='cmbFiles'>";
                while($arquivo = $diretorio -> read()){
                    echo '<option value='.$path.$arquivo.'>'.$arquivo.'</option>';
                }
                echo '</select>';
                $diretorio -> close();

            ?>
        <button name="btnOpen" id="btnOpen" value="abrir"> Abrir </button> 
        </form>
        <hr/>

        <form name="frmFileSave" id="frmFileSave" action="#" method="POST">
            <label for="edtFileName">File name:</label><br>
            <input type="text" id="edtFileName" name="edtFileName"><br>
            <label for="edtConteudo">Conteudo:</label><br>
            <textarea name="edtConteudo" cols="60" rows="6"></textarea><br>
            <button name="btnSave" id="btnSave" value="save"> Save </button> 
            <hr/>
        </form> 

    </div>


    <script type="text/javascript" src="files.js"></script>

<?php

    if(isset($_FILES['userfile'])){
        $myFile = $_FILES['userfile'];
        echo "Name: ".$myFile['name']."<br>";
        echo "Type: ".$myFile['type']."<br>";
        echo "Size: ".$myFile['size']."<br>";
        echo "Tmp Name: ".$myFile['tmp_name']."<br>";
        echo "Error: ".$myFile['error']."<br>";

        $uploaddir = 'files/';
        $uploadfile = $uploaddir . basename($myFile['name']);

        copy($myFile['tmp_name'],$uploadfile);

        echo '<pre>';
        if (move_uploaded_file($myFile['tmp_name'],$uploadfile)) {
            echo "Arquivo válido e enviado com sucesso.\n";
        } else {
            echo "Possível ataque de upload de arquivo!\n";
        }
        
        echo 'Aqui está mais informações de debug:';
        print_r($_FILES);
        
        print "</pre>";
    }else if(isset($_POST['btnOpen'])){

        echo $_POST['cmbFiles'];
    
        $file = $_POST['cmbFiles'];
        $filesize = filesize($file);
        $binary = abrir($file);


// unpack the data - notice that we create a format code using 'C%d'
// that will unpack the size of the file in unsigned chars
        $unpacked = unpack(sprintf('C%d', $filesize), $binary);

// reset array keys
        $unpacked = array_values($unpacked);

        $razao = 23;
        $fim = 'EF'; // quebra a linha
        $cont = 0;
        echo'<table><tr>';
        for ($i = 0; $i < sizeof($unpacked); $i++) {
            $cont += 1;
            $val = dectohex($unpacked[$i]);
            print '<td>' . $val . '</td>';
//          print ' ' . str_pad($unpacked[$i] , 3 , '0' , STR_PAD_LEFT) ;
            if($cont >= $razao || $val == $fim ){
            print '</tr><tr>';
            $cont=0;
            }        
        }
        echo'</tr></table>';


    }else if(isset($_POST['btnSave'])){
        
        $file = "files/".$_POST["edtFileName"];
        $value = $_POST["edtConteudo"];

        echo $file;

        salvar($value,$file);

    }    


        function hexa($number){
            $resp = $number;
            switch ($number) {
              case 10:
                $resp='A';
                break;
              case 11:
                $resp='B';
                 break;
              case 12:
                $resp='C';
                 break;
              case 13:
                $resp='D';
                break;
              case 14:
                $resp='E';
                break;
              case 15:
                $resp='F';
                break;
            }
            return $resp;
          }
    
          function dectohex($number){
            $B = hexa($number % 16);
            $A = hexa(intdiv($number,16));
            return $A.$B;
          }


          function embala($value,$file){
            return pack("nvc*", $value);
          }


          function abrir($file){
            $fp = fopen($file, 'rb');
            $binary = fread($fp, filesize($file));
            fclose($fp);
            return $binary;
          }

          function salvar($value,$file){
//        $filesize = filesize($file);
            $fp = fopen($file, 'wb');
            $binary = fwrite($fp, $value);
            fclose($fp);
          }


?>


</body>

</html>

