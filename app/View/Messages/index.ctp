<head>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<?php
  echo $this->Html->script('jquery', FALSE);
  echo $this->Html->css('Messages/index', array('inline' => FALSE));
?>

<div id="MessageAppHeader">
  <p id="MessageAppTitle">Message App</p>
  <p id="MessageAppDescription">Sends a message to an e-mail address.</p>
</div>
<div id="MessageAppContent">
  <div id='MessageAppForm'>
    <?php
      echo $this->Form->create();
      echo $this->Form->input('email');
      echo $this->Form->input('subject');
      echo $this->Form->input('message');
      echo "<div id='recaptcha' class='g-recaptcha' data-sitekey='6LfFNwoTAAAAAAU7LM5evxpX6DAu-G6Z75bzj6GI'></div>";
      echo $this->Js->submit('Send', array(
        'complete' => $this->Js->get('#MessageAppForm')->effect('slideOut'),
        'update' => '#Notification',
      ));
      echo $this->Form->end();
    ?>
  </div>
  <div id='Notification'></div>
</div>