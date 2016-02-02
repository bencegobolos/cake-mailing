<?php
class MessagesController extends AppController {
  public $helpers = array('Html', 'Form', 'Js');
  public $components = array('RequestHandler');

  /**
   * Set your ajax rendered message for Notification.ctp file.
   *
   * @param $type: 'success' or 'error'.
   * @param $notification_text: whatever you want to see.
   */
  public function set_notification_message($type, $notification_text) {
    $notification_message = "<p class='" . $type . "'>" . $notification_text . "</p>";
    $this->set('notification_message', $notification_message);
    $this->render('Notification', 'ajax');
  }

  /**
   * Sets up and sends an email.
   */
  public function send_email(){
    // Get recipients from config file ( webroot/files/mail_config.cfg )
    $cfg_file = fopen("files/mail_config.cfg", "r") or die("Unable to open file!");
    $cfg_to = fgets($cfg_file);
    fclose($cfg_file);

    // Set up the e-mail.
    $mail_to = $this->request->data('Message')['email'] . " , " . $cfg_to;
    $mail_subject = $this->request->data('Message')['subject'];
    $mail_message = "<html><body>";
    $mail_message .= "<h1>Hello MessageApp!</h1>";
    $mail_message .= "<p>" . $this->request->data('Message')['message'] . "</p>";
    $mail_message .= "</body></html>";
    $mail_headers = "From: " . strip_tags('bencegobolos@gmail.com') . "\r\n";
    $mail_headers .= "MIME-Version: 1.0\r\n";
    $mail_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // Send the mail.
    mail($mail_to, $mail_subject, $mail_message, $mail_headers);
  }

  public function index() {
    // Combobox for subject. There must be a better way to define it.
    $this->set('subjects', array(
      NULL => 'Please select an option',
      'Whats for lunch?' => 'Whats for lunch?',
      'What about dinner?' => 'What about dinner?',
      'Message app' => 'Message app',
      'Please read the terms and conditions' => 'Please read the terms and conditions',
    ));

    // Server-side validation variables.
    $invalid_email = !filter_var($this->request->data('Message')['email'], FILTER_VALIDATE_EMAIL);
    $empty_subject = empty($this->request->data('Message')['subject']);
    $long_message = (512 < strlen($this->request->data('Message')['message']));

    // Recaptcha validation. Get your recaptcha at recaptcha.net.
    $privatekey = "6LfFNwoTAAAAAJkevRVIC0ecom6QFQHaSZL3CJLx";
    $captcha = FALSE;
    if(null !== $this->request->data('g-recaptcha-response')) {
      $captcha = $this->request->data('g-recaptcha-response');
    }
    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $privatekey . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
    $response = $response->success;

    // Handle the form.
    if (!empty($this->data)) {
      if ($this->Message->save($this->data) && $response) {
        if ($this->RequestHandler->isAjax()) {
          $this->send_email();
          $this->set_notification_message('success', 'Your message has been successfully sent!');
        }
        else {
          $this->send_email();
          $this->Session->setFlash('Message sent');
          $this->redirect(array('action' => 'index'));
        }
      }

      // Error messages to user.
      else {
        if ($this->RequestHandler->isAjax()) {
          if ($invalid_email) {
            $this->set_notification_message('error', 'Type in a valid e-mail address!');
          }
          else if ($empty_subject) {
            $this->set_notification_message('error', 'Please select a subject!');
          }
          else if ($long_message) {
            $this->set_notification_message('error', 'Your message should be less then 512 chars!');
          }
          else if (empty($response)) {
            $this->set_notification_message('error', 'Check your recaptcha!');
          }
        }
      }
    }
  }
}