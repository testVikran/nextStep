<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses( 'CakeEmail', 'Network/Email' );
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	//public $components = array('DebugKit.Toolbar');
  var $isLogin = null;

  function setUserData() {

      $isLogintemp = $this->Session->read('User');
      $this->isLogin = $isLogintemp;
      $this->set('isLogin', $this->isLogin);
      
    }
	function _import($model, $constructor = null) {
      try {
        if (!$this->loadModel($model)) {
          throw new Exception();
        }
      } catch (Exception $e) {
        return $this->cakeError('missingModel', array(array('className' => $model, 'webroot' => '', 'base' => $this->base)));
        exit;
      }

      if ($constructor == null) {
        return new $model;
      } else {
        $constructor = implode(',', $constructor);
        return new $model($constructor);
      }
    }
    function _checkLogin() {
        if( $this->Session->read('User') ) {
           $Login =1;
           $this->Session->write('Login' , 1);
           $user = $this->Session->read('User');
           if(empty($user['r1']) || $user['r1'] != 1){
                $user_id =$user['user_id'];
                $this->redirect( array( 'controller' => 'home_pages', 'action' => 'r1' ) );
           }
           if($user['status'] == 1){
                $user_id =$user['user_id'];
                return $user_id;
           } else {
                $this->Session->delete('User');
                $this->Session->destroy();
                $this->redirect( array( 'controller' => 'home_pages', 'action' => 'index?status=6' ) );
           }
        } else {
            $this->redirect( array( 'controller' => 'home_pages', 'action' => 'index?status=5' ) );
        }
    }
    function setProductPrice(){
        $Product = $this->_import('Product');
        $productData = $Product->find('list', array(
            'conditions' => array('is_expaire' =>0 ,'is_saled' =>0,'status' =>1),
            'fields' => 'price'
        ));
        $this->set('productsPrice' , $productData);
    }
    function checkRegisterdGetId($emailid = null){
        $this->autoRender = false;
        $this->layout = null;
        $isMember = false;
        $User = $this->_import('User');
        if (trim($emailid) == ''){
            $emailid = $this->data['email'];
        }
        $loginData = $User->find('first', array(
            'fields' => array("User.id"),
            'conditions' => array('User.email' => $emailid)
        ));
        if (isset($loginData['User']['id']) && (int) $loginData['User']['id']) {
            $isMember = (int) $loginData['User']['id'];
        }
        return $isMember;
    }
      function sendMail($emailid, $message, $subject, $success_message, $view, $attachment = null, $cc = null, $bcc = '', $semailid = MAIL_SMTP_EMAILID, $sname = "NextStep", $replyTo = "") {
        $sta_email = Configure::read('emailid');
        #Added by Ankush on 1st Aug, 2016
        if (isset($sta_email) && $sta_email != ''){
            $cc = $sta_email;
            if($bcc != ''){
                $bcc = $sta_email;
            }
            $emailid = $sta_email;
        }
        #ends here
        $subjectArray = explode('_', $subject);
        $subject = $subjectArray[0];

        $email = new CakeEmail('elastic');
        $from = $semailid;
        $fromName = $sname;
        // Temp Code to log unverified job issue.---------------START
        $temp = explode('@', $semailid);
        $tempDomain = explode('.', $temp[1]);
        $domain = $tempDomain[0];
        if ($domain != 'nextsteptech') {
            $from = "noreply@nextsteptech.in";
        }
        // Temp Code to log unverified job issue.---------------ENDS
        if ($from == '' || $from == 'support@nextsteptech.in')
            $from = "noreply@nextsteptech.in";
        else
            $from = $semailid;
        $message['from'] = $from;
        $email->viewVars(array('message' => $message));
        if ($attachment != '')
            $email->attachments($attachment);
        if ($cc != '' && empty($sta_email))
            $email->cc($cc);

        if (isset($message['cc']) && !empty($message['cc']) && empty($sta_email)) {
            $email->cc($message['cc']);
        }
        #commented by Ankush on 1 Aug, 2016
        //if ($bcc != '' && empty($sta_email))
        if($bcc != ''){           
            $email->bcc($bcc);
        }
        #ends here
        if (isset($message['bcc']) && !empty($message['bcc']) && empty($sta_email)) {
            $email->bcc($message['bcc']);
        }

        if (isset($message['replyTo'])) {
            $semailid = $message['replyTo'];
        }
        try {
            $email->template($view);
            $email->emailFormat('html');
            $email->to($emailid);
            $email->from($from, $fromName);
            $email->replyTo($semailid);
            $email->subject($subject);
            if ($email->send()) {
                return $success_message;
            } else {
                return "Error Sending Mail";
            }
        } catch (Exception $e) {
            $this->log("Failed to send email: " . $e->getMessage());
            echo "error occure" . $e->getMessage();
            $EmailTrack = $this->_import('EmailTrack');
            $EmailTrack->create();
            $em['EmailTrack'] = array('emailid' => $emailid, 'subject' => $subject, 'view' => $view, 'message' => serialize($message), 'error_mail' => $e->getMessage(), 'from_mail' => 'JobSeeker');
            $EmailTrack->save($em);
            echo "error".$e->getMessage();
        }
    }
}
