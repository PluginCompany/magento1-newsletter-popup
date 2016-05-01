<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Newsletter Pop-up, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Newsletterpopup_SubscriberController extends Mage_Core_Controller_Front_Action
{

    /**
     * New subscription action
     */
    public function newAction()
    {
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $session            = Mage::getSingleton('core/session');
            $customerSession    = Mage::getSingleton('customer/session');
            $email              = (string) $this->getRequest()->getPost('email');

            try {
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    Mage::throwException($this->__('Please enter a valid email address.'));
                }

                if (Mage::getStoreConfig(Mage_Newsletter_Model_Subscriber::XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG) != 1 &&
                    !$customerSession->isLoggedIn()) {
                    Mage::throwException($this->__('Sorry, but administrator denied subscription for guests. Please <a href="%s">register</a>.', Mage::helper('customer')->getRegisterUrl()));
                }

                $ownerId = Mage::getModel('customer/customer')
                    ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                    ->loadByEmail($email)
                    ->getId();
                if ($ownerId !== null && $ownerId != $customerSession->getId()) {
                    Mage::throwException($this->__('This email address is already assigned to another user.'));
                }

                $status = Mage::getModel('newsletter/subscriber')->subscribe($email);
                if ($status == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                    $status = 'success';
                    $msg = $this->__('Confirmation request has been sent.');
                }
                else {
                    $status = 'success';
                    $msg = $this->__('Thank you for your subscription.');
                }
            }
            catch (Mage_Core_Exception $e) {
                $status = 'error';
                $msg =  $this->__('There was a problem with the subscription: %s', $e->getMessage());
            }
            catch (Exception $e) {
                $status = 'error';
                $msg =  $this->__('There was a problem with the subscription.');
            }
        }
        $this->getResponse()->setBody(
            json_encode(array('status'=>$status,'message'=>$msg))
        );
    }

}