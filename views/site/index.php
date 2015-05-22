<?php
/* @var $this yii\web\View */
$this->title = 'EZStory';
?>

<div class="content-wrap">
    <div id="post-wrap" class="col-lg-5 col-md-5 col-sm-12 col-xs-12" ng-controller="postCtrl">
        <input type="text" class="form-control" value="Title">
    </div>

    <div id="social-wrap" class="col-lg-7 col-md-7 col-sm-12 col-xs-12" ng-controller="socialCtrl">
        <div class="s-w-top">
            <i class="fa fa-twitter s-w-type"></i>
            <i class="fa fa-instagram s-w-type"></i>
            <i class="fa fa-youtube s-w-type"></i>
            <i class="fa fa-reddit s-w-type"></i>
            <i class="fa fa-vimeo-square s-w-type"></i>
        </div>
    </div>
</div>