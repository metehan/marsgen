<?php

namespace Marsgen\Libs;

/**
 * MarsgenParser
 */
class MarsgenParser{
    
    function __construct($template, $seed)
    {
        $this->template = $template;
        $this->seed = $seed;
    }

    /*
    * Replace: For
    */
    function parse(){
        $this->replaceFor();
        $this->template = $this->replaceIsset($this->template,$this->seed);
        $this->template = $this->replaceVars($this->template,$this->seed);
        return $this->template;
    }

    /*
    * Replace: For
    */
    function replaceFor(){
        $forPattern = "/\/\*\{for\:(.*)\}\*\/(.*)\/\*\{\/for\}\*\//sU";
        $catch = preg_match_all($forPattern, $this->template, $matches);

        if($catch){
            foreach ($matches[0] as $k => $v) {
                $output   = '';
                $block    = $matches[0][$k];
                $variable = $matches[1][$k];
                $content  = $matches[2][$k];

                $loopfor = $this->seed[$variable];
                foreach ($loopfor as $key => $value) {
                    $step1 = $this->replaceIsset($content,$value,$variable.'>');
                    $step2 = $this->replaceVars($step1,$value,$variable.'>');
                    $output .= $step2;
                }

                $this->template = str_replace($block,$output,$this->template);
            }
        }
    }//replaceFor

    /*
    * Replace: If
    */
    function replaceIf(){
        $ifPattern = "/\/\*\{if\:(.*) (\W+) (.*)\}\*\/(.*)\/\*\{\/if\}\*\//sU";
        $catch = preg_match_all($forPattern, $this->template, $matches);

        //Check if any text is catched
        if($catch){
            //Start replacing for each item
            foreach ($matches[0] as $k => $v){
                //Human readable shortcuts for matched elements
                $output     = '';
                $block      = $matches[0][$k];
                $first      = $matches[1][$k];
                $operator   = $matches[2][$k];
                $second     = $matches[3][$k];
                $content    = $matches[4][$k];

                //Logic for replacement
                if(isset($seed[$variable])){
                    $output .= $content;
                }else{
                    $output .= "";
                }

                //Replace element 
                $template = str_replace($block,$output,$template);
            }//forEach
            return $template;
        }
    }//replaceIf

    /*
    * Replace: Isset
    */
    function replaceIsset($template,$seed,$prefix = ''){
        $issetPattern = "/\/\*\{isset\:$prefix(.*)\}\*\/(.*)\/\*\{\/isset\}\*\//sU";
        $catch = preg_match_all($issetPattern, $template, $matches);

        //Check if any text is catched
        if($catch){
            //Start replacing for each item
            foreach ($matches[0] as $k => $v){
                //Human readable shortcuts for matched elements
                $output   = '';
                $block    =  $matches[0][$k];
                $variable =  $matches[1][$k];
                $content  =  $matches[2][$k];

                //Logic for replacement
                if(isset($seed[$variable])){
                    $output .= $content;
                }else{
                    $output .= "";
                }

                //Replace element 
                $template = str_replace($block,$output,$template);
            }//forEach
        }//catch

        return $template;
    }//replaceIsset

    /*
    * Replace: Variables
    */
    function replaceVars($template,$seed,$prefix = ''){
            if(!is_array($seed)) return $template;
            foreach ($seed as $key => $value) {
                if(!is_array($value)){
                    $template = str_replace('/*{'.$prefix.$key.'}*/',$value,$template);
                };
            }
            return $template;
    }//replaceVars

}