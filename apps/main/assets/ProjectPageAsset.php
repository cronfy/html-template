<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 15.03.18
 * Time: 12:37
 */

namespace main\assets;

use main\models\Project;
use main\models\WorkPage;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\AssetBundle;

class ProjectPageAsset extends AssetBundle
{

    protected function getWidgetsCss($project) {
        /** @var Project $project */


        $result = [];

        foreach ($project->getWork()->getWidgets() as $widget) {
            $files = FileHelper::findFiles(
                Yii::getAlias($project->getWidgetDir($widget->sid)),
                ['only' => ['*.css']]
            );

            foreach ($files as $file) {
                $result[] = Url::to(['page/show-widget-asset',
                    'projectName' => $project->name,
                    'widgetName' => $widget->sid, 'asset' => basename($file)]);
            }
        }

        return $result;
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        /** @var Project $project */
        $project = Yii::$app->view->params['html-template.project.current'];

        $config = $project->getConfig()->raw;

        foreach (@$config['assets'] ?: [] as $assetName => $contents) {
            foreach (@$contents['js'] ?: [] as $js) {
                $this->js[] = $js;
            }
            foreach (@$contents['css'] ?: [] as $css) {
                $this->css[] = $css;
            }
        }

        // подключить css /projects/имя-проекта/имя-проекта.css
        $this->css[] = Url::to(['page/show-project-asset', 'projectName' => $project->name, 'asset' => $project->name . '.css']);

        // подключить все css виджетов
        $this->css =array_merge($this->css, $this->getWidgetsCss($project));

        /** @var WorkPage $page */
        if ($page = @Yii::$app->view->params['current.workPage']) {
            if (file_exists($page->getDir() . '/' . $page->sid . '.css')) {
                // подключить css страницы из /projects/имя-проекта/src/pages/имя-страницы/имя-страницы.css
                $this->css[] = Url::to(['page/show-page-asset', 'projectName' => $project->name, 'pageSid' => $page->sid, 'asset' => "{$page->sid}.css"]);
            }

            if (file_exists($page->getDir() . '/' . $page->sid . '.js')) {
                // подключить js страницы из /projects/имя-проекта/src/pages/имя-страницы/имя-страницы.js
                $this->js[] = Url::to(['page/show-page-asset', 'projectName' => $project->name, 'pageSid' => $page->sid, 'asset' => "{$page->sid}.js"]);
            }
        }

    }
}