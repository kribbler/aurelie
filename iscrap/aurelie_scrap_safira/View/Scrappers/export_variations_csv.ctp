<?php
 $line= $items[0];
 $this->Csv->addRow(array_keys($line));
 unset($items[0]);
 foreach ($items as $item)
 {
      $line = $item;
       $this->Csv->addRow($line);
 }
 $filename='Safira_Variable_' . date('Ymdhis');
 echo  $this->Csv->render($filename);
?>

