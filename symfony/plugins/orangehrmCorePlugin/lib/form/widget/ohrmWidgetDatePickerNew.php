<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

class ohrmWidgetDatePickerNew extends sfWidgetFormInput {

    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        if (array_key_exists('class', $attributes)) {
            $attributes['class'] .= ' ohrm_datepicker';
        } else {
            $attributes['class'] = 'ohrm_datepicker';
        }

        $html = parent::render($name, $value, $attributes, $errors);
        $html .= $this->renderTag('input', array(
                    'type' => 'button',
                    'id' => "{$this->attributes['id']}_Button",
                    'class' => 'calendarBtn',
                    'style' => 'float: none; display: inline; margin-left: 6px;',
                    'value' => '',
                ));

        $javaScript = sprintf(<<<EOF
 <script type="text/javascript">

    var datepickerDateFormat = '%s';
    var displayDateFormat = datepickerDateFormat.replace('yy', 'yyyy');

    $(document).ready(function(){

        var rDate = trim($("#%s").val());
            if (rDate == '') {
                $("#%s").val(displayDateFormat);
            }

        //Bind date picker
        daymarker.bindElement("#%s",
        {
            onSelect: function(date){

            },
            dateFormat : datepickerDateFormat,
            onClose: function(){
                $(this).valid();
            }
        });

        $('#%s_Button').click(function(){
            daymarker.show("#%s");

        });
    });
</script>
EOF
                        ,
                        get_datepicker_date_format(sfContext::getInstance()->getUser()->getDateFormat()),
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id'],
                        $this->attributes['id']
        );

        return $html . $javaScript;
    }

}

