ezstory.controller('socialCtrl', function($scope, $http, $timeout, $sce){
    // define currently social type, default is twitter
    $scope.currentSocialType = 'twitter';
    // define default search type is text
    $scope.currentSocialSearchType = 'text';
    // define output default image path
    $scope.outputDefaultImg = '/image/arrow-up.png';

    /**
     * change social type
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.changeType = function(event){
        var $obj = $(event.target),
            type = $obj.attr('data-type');

        $obj.siblings('i').removeClass('active');
        $obj.addClass('active');

        $scope.currentSocialType = type;
    }

    /**
     * get social input template
     * @return {[type]} [description]
     */
    $scope.getInputTpl = function(){
        return '/template/socialInput/' + $scope.currentSocialType + '.html';
    }

    /**
     * get social output template
     * @return {[type]} [description]
     */
    $scope.getOutputTpl = function(){
        return '/template/socialOutput/' + $scope.currentSocialType + '_' + $scope.currentSocialSearchType + '.html';
    }

    /**
     * change input search type
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.changeInputSearchType = function(event){
        var $obj = $(event.target),
            type = $obj.attr('data-type');

        $obj.siblings('a').removeClass('active');
        $obj.addClass('active');

        $scope.currentSocialSearchType = type;
    }

    /**
     * search 
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.search = function(event){
        var $obj = $(event.target);
        $scope.removeGuide = true;
        $scope.noAccount = false;

        // build url
        var url = '/social/' + this.currentSocialType + '/search';
        var data = {
            keyword : $obj.closest('.t-s-search-input-wrap').find('.search-keyword').val(),
            keyword_type : $scope.currentSocialSearchType
        }

        // post data
        $scope.socialData = [];
        $http({
            method: 'POST',
            url: url,
            data: $.param(data),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(res){
            if(res.error){
                $scope.noAccount = true;
                $scope.noAccountMessage = $sce.trustAsHtml( res.message );
            }else{
                $scope.socialData = res.data;
            }
        })
    }
});