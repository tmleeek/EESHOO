<?php
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meigeeteam.com <nick@meigeeteam.com>
 * @copyright Copyright (C) 2010 - 2014 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBlacknwhite_Block_Adminhtml_System_Config_Form_Field_Font extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Get the default HTML for this option
        $html = parent::_getElementHtml($element);

        $html .= '<br/><div id="themeoptionsblacknwhite_gfontmain_preview" style="font-size:20px; margin-top:5px;">The quick brown fox jumps over the lazy dog</div>
		<script>
        var googleFontPreviewModel = Class.create();

        googleFontPreviewModel.prototype = {
            initialize : function()
            {
                this.fontElement = $("meigee_blacknwhite_design_appearance_gfontmain");
                this.previewElement = $("themeoptionsblacknwhite_gfontmain_preview");
                this.loadedFonts = "";

                this.refreshPreview();
                this.bindFontChange();
            },
            bindFontChange : function()
            {
                Event.observe(this.fontElement, "change", this.refreshPreview.bind(this));
                Event.observe(this.fontElement, "keyup", this.refreshPreview.bind(this));
                Event.observe(this.fontElement, "keydown", this.refreshPreview.bind(this));
            },
        	refreshPreview : function()
            {
                if ( this.loadedFonts.indexOf( this.fontElement.value ) > -1 ) {
                    this.updateFontFamily();
                    return;
                }

        		var ss = document.createElement("link");
        		ss.type = "text/css";
        		ss.rel = "stylesheet";
        		ss.href = "//fonts.googleapis.com/css?family=" + this.fontElement.value;
        		document.getElementsByTagName("head")[0].appendChild(ss);

                this.updateFontFamily();

                this.loadedFonts += this.fontElement.value + ",";
            },
            updateFontFamily : function()
            {
                $(this.previewElement).setStyle({ fontFamily: this.fontElement.value });
            }
        }

        googleFontPreview = new googleFontPreviewModel();
		</script>
        ';
        return $html;
    }
}