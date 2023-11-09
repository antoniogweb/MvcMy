<?php if (!defined('EG')) die('Direct access not allowed!'); ?>
Gentile <?php echo $utente[0]["utenti"]["nome"];?>, <br />
di seguito le credenziali per accedere alla nostra piattaforma: <br /> <br />

Email: <?php echo $utente[0]["utenti"]["email"];?><br />
Password: <?php echo $password;?><br /><br />

Può eseguire l'accesso alla piattaforma al <a href="<?php echo Url::getRoot()."utenti/login"?>">seguente indirizzo</a>.<br /><br />

Cordiali saluti
