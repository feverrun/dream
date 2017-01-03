<?php
use common\service\GlobalUrlService;
use \admin\components\StaticService;
StaticService::includeStaticCss("/editormd/css/editormd.min.css",\admin\assets\AdminAsset::className());
StaticService::includeStaticJs("/editormd/editormd.min.js",\admin\assets\AdminAsset::className());
StaticService::includeAppJsStatic("/js/md/index.js",\admin\assets\AdminAsset::className());
?>
<div class="row">
    <div class="row-in">
        <div class="columns-24">
			<?php echo \Yii::$app->view->renderFile("@admin/views/common/posts_tab.php", ['current' => 'md_index']); ?>
        </div>
    </div>
</div>