<?php if (!defined('EG')) die('Direct access not allowed!'); ?>
Nel giorno <?php echo date("d/m/Y");?> sono state eseguite <?php $numero;?> modifiche dalle aziende.<br /><br />
Segui il <a href="<?php echo $this->baseUrl."/revisioni/main?dal=$oggi&al=$oggi&ordineazienda=Y"?>">seguente link</a> per vedere il resoconto giornaliero.
