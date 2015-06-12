<?php
/* @var $this yii\web\View */
$this->title = 'EZStory';
?>

<div class="content-wrap">
    <div id="post-wrap" class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <input type="text" class="form-control" placeholder="Your title...">
    </div>

    <div id="social-wrap" class="col-lg-7 col-md-7 col-sm-12 col-xs-12" ng-controller="socialCtrl">
        <div class="s-w-top">
            <div class="s-w-t-type">
                <i class="fa fa-twitter s-w-type active" ng-click="changeType($event)" data-type="twitter"></i>
                <i class="fa fa-youtube s-w-type" ng-click="changeType($event)" data-type="youtube"></i>         
                <i class="fa fa-vimeo-square s-w-type" ng-click="changeType($event)" data-type="vimeo"></i>
                <i class="fa fa-instagram s-w-type" ng-click="changeType($event)" data-type="instagram"></i>
                <i class="fa fa-reddit s-w-type" ng-click="changeType($event)" data-type="reddit"></i>
            </div>
        </div>

        <div class="s-w-t-input">
            <div class="s-w-t-i-tpl clearfix" ng-include src="getInputTpl();"></div>
        </div>

        <div class="s-w-t-output">
            <div class="s-w-t-o-tpl clearfix" ng-include src="getOutputTpl();"></div>
        </div>
    </div>
</div>