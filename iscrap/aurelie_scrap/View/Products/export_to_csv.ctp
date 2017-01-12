<?php
//pr($items);die();
 $line= $items[0];
 $this->Csv->addRow(array_keys($line));
 unset($items[0]);
 foreach ($items as $item)
 {
      $line = $item;
       $this->Csv->addRow($line);
 }
 $filename='Aurelie_products_' . date('Ymdhis');
 echo  $this->Csv->render($filename);
?>

