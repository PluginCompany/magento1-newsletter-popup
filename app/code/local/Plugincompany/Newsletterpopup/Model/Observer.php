<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Newsletter Pop-up, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Newsletterpopup_Model_Observer
{
    public function controllerActionLayoutLoadBefore($observer)
    {
        $controllerAction = $observer->getEvent()->getAction();
        $layout = $observer->getEvent()->getLayout();
        if ($controllerAction && $layout && $controllerAction instanceof Mage_Adminhtml_System_ConfigController) {
            if ($controllerAction->getRequest()->getParam('section') == 'plugincompany_newsletterpopup') {
                $layout->getUpdate()->addHandle('plugincompany_newsletterpopup_config');
            }
        }
        return $this;
    }
}