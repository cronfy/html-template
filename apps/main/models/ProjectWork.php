<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 13.03.18
 * Time: 13:52
 */

namespace main\models;

use yii\base\BaseObject;

class ProjectWork extends BaseObject
{
    /**
     * @var Project
     */
    public $project;

    protected $_pages;
    public function getPages() {
        if (!$this->_pages) {
            $pages = [];
            foreach (glob($this->project->getPagesDir() . '/*', GLOB_ONLYDIR) as $dir) {
                $pageSid = basename($dir);
                $page = new WorkPage([
                    'sid' => $pageSid,
                    'project' => $this->project,
                    'fileExists' => true,
                ]);
                $pages[$pageSid] = $page;
            }

            $this->_pages = $pages;
        }

        return $this->_pages;
    }

    public function getPage($pageSid) {
        if (@$this->pages[$pageSid]) return $this->pages[$pageSid];

        $page = new WorkPage([
            'sid' => $pageSid,
            'project' => $this->project,
            'fileExists' => false,
        ]);

        $this->_pages[$pageSid] = $page;

        return $page;
    }
}