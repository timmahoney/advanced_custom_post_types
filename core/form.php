<?php
/**
  * Form Builder
  *
  * This is the long description for a DocBlock. This text may contain
  * multiple lines and even some _markdown_.
  *
  * * Markdown style lists function too
  * * Just try this out once
  *
  * The section after the long description contains the tags; which provide
  * structured meta-data concerning the given element.
  *
  * @author  Kevin Dees
  *
  * @since 0.6
  * @version 0.6
  *
  * @global string $acpt_version
  */
class form extends acpt {
    public $formName = null;

    /**
     * Make Form.
     * 
     * @param string $singular singular name is required
     * @param array $opts args override and extend
     */
    function make($name, $opts=array()) {
        if(!$name) exit('Making Form: You need to enter a singular name.');

        if(isset($opts['method'])) :
            $field = '<form id="'.$name.'" ';
            $field .= isset($opts['method']) ? 'method="'.$opts['method'].'" ' : 'method="post" ';
            $field .= isset($opts['action']) ? 'action="'.$opts['action'].'" ' : 'action="'.$name.'" ';
            $field .= '>';
        endif;

        $this->formName = $name;
        
        if(isset($field)) echo $field;
    }
    
    /**
     * Form Text.
     * 
     * @param string $singular singular name is required
     * @param array $opts args override and extend
     */
    function text($name, $opts=array(), $label = true) {
        if(!$this->formName) exit('Making Form: You need to make the form first.');
        if(!$name) exit('Making Input: You need to enter a singular name.');
        global $post;

        $fieldName = 'acpt_text_'.$this->formName.'_'.$name;

        // value
        if($value = get_post_meta($post->ID, $fieldName, true)) : 
            $value = 'value="'.$value.'"';
        endif;

         // class
        if ( is_string($opts['class']) ) :
            $class = $opts['class'];
        endif;
        
        // id 
        if ( isset($opts['id']) ) :
            $id = 'id="'.$opts['id'].'"';
        endif;

        // readonly
        if ( isset($opts['readonly']) ) :
            $readonly = 'readonly="readonly"';
        endif;

        // size
        if ( is_integer($opts['size']) ) :
            $size = 'size="'.$opts['size'].'"';
        endif;

        // name
        if ( is_string($fieldName) ) :
            $name = 'name="'.$fieldName.'"';
        endif;

        // label
        if($label) :
            $label = '<label for="'.$fieldName.'">'.$name.'</label>';
        endif;

        $field = "<input type=\"text\" class=\"text $fieldName $class\" $id $size $readonly $fieldName $name $value />";
        
        echo $label.$field;
    }
    
    /**
     * Form Textarea.
     * 
     * @param string $singular singular name is required
     * @param array $opts args override and extend
     */
    function textarea($name, $opts=array()) {
        if(!$this->formName) exit('Making Form: You need to make the form first.');
        if(!$name) exit('Making Textarea: You need to enter a singular name.');
        global $post;

        $fieldName = 'acpt_textarea_'.$this->formName.'_'.$name;

        // value
        if($value = get_post_meta($post->ID, $fieldName, true)) : 
            $value;
        endif;

         // class
        if ( is_string($opts['class']) ) :
            $class = $opts['class'];
        endif;
        
        // id 
        if ( isset($opts['id']) ) :
            $id = 'id="'.$opts['id'].'"';
        endif;

        // readonly
        if ( isset($opts['readonly']) ) :
            $readonly = 'readonly="readonly"';
        endif;

        // size
        if ( is_integer($opts['size']) ) :
            $size = 'size="'.$opts['size'].'"';
        endif;

        // name
        if ( is_string($fieldName) ) :
            $name = 'name="'.$fieldName.'"';
        endif;

        // label
        if($label) :
            $label = '<label for="'.$fieldName.'">'.$name.'</label>';
        endif;

        $field = "<textarea class=\"textarea $fieldName $class\" $id $size $readonly $fieldName $name />$value</textarea>";

        echo $label.$field;
    }
    
    /**
     * Form WP Editor.
     * 
     * @param string $singular singular name is required
     * @param array $opts args override and extend
     */
    function editor($name, $opts=array()) {
        if(!$this->formName) exit('Making Form: You need to make the form first.');
        if(!$name) exit('Making Editor: You need to enter a singular name.');
        global $post;

        if($value = get_post_meta($post->ID, 'acpt_'.$this->formName.'_'.$name, true)) $content = $value;
        wp_editor(
            $content,
            'wysisyg_'.$this->formName.'_'.$name,
            array_merge($opts,array('textarea_name' => 'acpt_'.$this->formName.'_'.$name))
        );
    }
    
    /**
     * End Form.
     * 
     * @param string $singular singular name is required
     * @param array $opts args override and extend
     */
    function end($name=null, $opts=array()) {
        if($name) :
            $field = $opts['type'] == 'button' ? '<input type="button"' : '<input type="submit"';
            $field .= 'value="'.$name.'" />';
            $field .= '</form>';
        endif;

        $this->formName = null;
        
        if(isset($field)) echo $field;
    }
}   