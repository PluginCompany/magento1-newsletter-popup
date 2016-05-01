<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Newsletter Pop-up, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Newsletterpopup_Block_Popup extends Mage_Core_Block_Template
{
    const POPUP_DELAY = 0;
    const COLOR = '#ffffff';
    const TITLE_SIZE = '25px';
    const RIGHT_TITLE_COLOR = '#2c3e50';
    const FONT_SIZE = '20px';
    const LEFT_ICON_COLOR = '#ffffff';
    const RIGHT_ICON_COLOR = '#34495e';
    const LEFT_BACKGROUND_COLOR = '#3498db';
    const RIGHT_BACKGROUND_COLOR = '#ecf0f1';
    const ICON_SIZE = 18;
    const OVERLAY_OPACITY = 0.6;
    const BUTTON_COLOR = '#3498db';
    const BUTTON_BORDER_COLOR = '#2a8bcc';
    const LEFT_ICON = 'fa-thumbs-up';
    const RIGHT_ICON = 'fa-envelope';
    const CLOSE_BUTTON = '#bdc3c7';

    protected function _toHtml()
    {
        $req = $this->getRequest()->getOriginalPathInfo();

        if (!$this->isEnabled()) {
            return $this;
        }

        $loggedIn = Mage::getSingleton('customer/session')->isLoggedIn();

        if(!$loggedIn && !Mage::getStoreConfigFlag('plugincompany_newsletterpopup/general/show_guest')){
            return $this;
        }

        if($loggedIn && !Mage::getStoreConfigFlag('plugincompany_newsletterpopup/general/show_loggedin')){
            return $this;
        }

        return parent::_toHtml();
    }

    public function isEnabled(){
        return Mage::getStoreConfigFlag('plugincompany_newsletterpopup/general/enabled');
    }

    public function getConfig($value)
    {
        $config = Mage::getStoreConfig('plugincompany_newsletterpopup/' . $value);
        if ($config) {
            if ((stristr($value, 'color') || stristr($value,'clr') || stristr($value,'close_button')) && !stristr($config,'#')) {
                $config = '#' . $config;
            }
            return $config;
        }

        $value = explode('/', $value);
        $value = $value[1];

        if (stristr($value, 'title_font_size')) {
            return self::TITLE_SIZE;
        }
        if (stristr($value, 'font_size')) {
            return self::FONT_SIZE;
        }
        if (stristr($value, 'left_icon_color')) {
            return self::LEFT_ICON_COLOR;
        }
        if (stristr($value, 'right_icon_color')) {
            return self::RIGHT_ICON_COLOR;
        }
        if (stristr($value, 'right_title_color')) {
            return self::RIGHT_TITLE_COLOR;
        }

        if($value == 'button_color'){
            return self::BUTTON_COLOR;
        }
        if($value == 'button_border_color'){
            return self::BUTTON_BORDER_COLOR;
        }

        if (stristr($value, 'color')) {
            return self::COLOR;
        }
        if (stristr($value, 'icon_size')) {
            return self::ICON_SIZE;
        }
        if ($value == 'left_background_clr') {
            return self::LEFT_BACKGROUND_COLOR;
        }
        if ($value == 'right_background_clr') {
            return self::RIGHT_BACKGROUND_COLOR;
        }
        if ($value == 'overlay_opacity') {
            return self::OVERLAY_OPACITY;
        }
        if ($value == 'right_icon') {
            return self::RIGHT_ICON;
        }
        if ($value == 'left_icon') {
            return self::LEFT_ICON;
        }
        if ($value == 'close_button') {
            return self::CLOSE_BUTTON;
        }
    }

    public function getFormUrl()
    {
        $url = $this->getUrl('newsletterpopup/subscriber/new');
        return $url;
    }
}
