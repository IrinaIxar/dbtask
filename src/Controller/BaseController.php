<?php
class BaseController {
    /**
     * Render main layout with current action view if it is needed
     * 
     * @param array $params params that are send to be shown 
     */
    public function renderLayout ($params=[]) {
        extract($params);
        ob_start();
        require ROOTPATH.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.'Layout'.DIRECTORY_SEPARATOR."layout.html";
        return ob_get_clean();        
    }
    
    /**
     * Render view for current action
     * 
     * @param string $viewName name of html file is rendered
     * @param array $params params that are send to be shown 
     */
    public function render ($viewName='', array $params = []) {
        extract($params);
        ob_start();
        require ROOTPATH.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.$viewName;
        $body = ob_get_clean();
        ob_end_clean();
        return $this->renderLayout(['body' => $body]);        
    } 
}