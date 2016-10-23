<?php

namespace System\Library;

class Document {

    private $title;
    private $description;
    private $keywords;
    private $links = array();
    private $styles = array();
    private $scripts = array();

    /**
     * 
     * @param type $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * 
     * @return type
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * 
     * @param type $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @return type
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param type $keywords
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    /**
     * 
     * @return type
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * 
     * @param type $href
     * @param type $rel
     */
    public function addLink($href, $rel) {
        $this->links[$href] = array(
            'href' => $href,
            'rel' => $rel
        );
    }

    /**
     * 
     * @return type
     */
    public function getLinks() {
        return $this->links;
    }

    /**
     * 
     * @param type $href
     * @param type $rel
     * @param type $media
     */
    public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
        $this->styles[$href] = array(
            'href' => $href,
            'rel' => $rel,
            'media' => $media
        );
    }

    /**
     * 
     * @return type
     */
    public function getStyles() {
        return $this->styles;
    }

    /**
     * 
     * @param type $href
     * @param type $postion
     */
    public function addScript($href, $postion = 'header') {
        $this->scripts[$postion][$href] = $href;
    }

    /**
     * 
     * @param type $postion
     * @return type
     */
    public function getScripts($postion = 'header') {
        if (isset($this->scripts[$postion])) {
            return $this->scripts[$postion];
        } else {
            return array();
        }
    }

}
