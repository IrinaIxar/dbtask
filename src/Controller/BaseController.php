<?php

class BaseController
{
    protected $methodDefaults = [];

    /**
     * Render main layout with current action view if it is needed
     *
     * @param  array  $params  params that are send to be shown
     */
    public function renderLayout($params = [])
    {
        extract($params);
        ob_start();
        require implode(DIRECTORY_SEPARATOR, [ROOTPATH, 'src', 'View', 'Layout', 'layout.html']);
        echo ob_get_clean();
    }

    /**
     * Render view for current action
     *
     * @param  string  $viewName  name of html file is rendered
     * @param  array  $params  params that are send to be shown
     */
    public function render($viewName = '', array $params = [])
    {
        extract($params);
        ob_start();
        require implode(DIRECTORY_SEPARATOR, [ROOTPATH, 'src', 'View', $viewName]);
        $body = ob_get_clean();
        ob_end_clean();
        return $this->renderLayout(['body' => $body]);
    }

    /**
     * Creates sort fields array
     *
     * @param  array fields names array
     * @return array sort fields array with ascending attribute
     */
    public function addSortFieldsArray($fields = [])
    {
        $sortFields = [];
        foreach ($fields as $fieldName) {
            $sortFields[$fieldName] = [
                'ascending' => false
            ];
        }

        return $sortFields;
    }
}