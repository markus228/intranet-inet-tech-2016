<?php
/**
 * @var \view\LoginView $this
 */
?>

<div class="container">

    <div class="alert-container">
        <?
        foreach($this->getAlerts() as $alert) {
            echo $alert;
        }
        ?>
    </div>


    <form class="form-signin" method="POST" action="" role="form">
        <h2 class="form-signin-heading"><?=$this->getHeaderText()?> <span class="badge"><?=$this->getBadge()?></span></h2>
        <input type="input" name="user" class="form-control" placeholder="Benutzername" required autofocus>
        <input type="password" name ="password" class="form-control" placeholder="Passwort" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>

</div> <!-- /container -->