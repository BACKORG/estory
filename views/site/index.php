<?php
/* @var $this yii\web\View */
$this->title = 'EZStory';
?>

<div class="content-wrap">
    <!-- post section -->
    <div id="post-wrap" class="col-lg-5 col-md-5 col-sm-12 col-xs-12" ng-controller="postCtrl">
        <!-- load post header -->
        <div class="p-w-type clearfix" ng-include src="getPostHeaderTpl();"></div>

        <!-- load post body -->
        <div class="p-w-body clearfix" ng-include src="getPostBodyTpl();"></div>

        <!-- load modal -->
        <div ng-include src="loadPostHeaderModal();"></div>
    </div>

    <!-- social data section -->
    <div id="social-wrap" class="col-lg-7 col-md-7 col-sm-12 col-xs-12" ng-controller="socialCtrl">
        <div class="s-w-top">
            <div class="s-w-t-type">
                <i class="fa fa-twitter s-w-type active" ng-click="changeType($event)" tooltips data-original-title="twitter" data-type="twitter"></i>
                <i class="fa fa-youtube s-w-type" ng-click="changeType($event)" tooltips data-original-title="youtube" data-type="youtube"></i>         
                <i class="fa fa-vimeo-square s-w-type" ng-click="changeType($event)" tooltips data-original-title="vimeo" data-type="vimeo"></i>
                <i class="fa fa-instagram s-w-type" ng-click="changeType($event)" tooltips data-original-title="instagram" data-type="instagram"></i>
                <i class="fa fa-reddit s-w-type" ng-click="changeType($event)" tooltips data-original-title="reddit" data-type="reddit"></i>
            </div>
        </div>

        <!-- load social input -->
        <div class="s-w-t-input">
            <div class="s-w-t-i-tpl clearfix" ng-include src="getInputTpl();"></div>
        </div>

        <!-- load social output -->
        <div class="s-w-t-output">
            <div class="s-w-t-o-tpl clearfix" ng-include src="getOutputTpl();"></div>
        </div>
    </div>
</div>