<?php
echo '<pre>';
print_r( $_POST );
print_r( $_FILES );
echo '</pre>';
if(move_uploaded_file ( $_FILES['upload']['tmp_name'],'/home/c/cu57484/Upload/offers.xml')){
    echo 'Success';
}
else{
    echo 'Error';
}
?>