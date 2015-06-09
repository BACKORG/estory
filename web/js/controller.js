ezstory.controller('socialCtrl', function($scope, $http, $timeout, $sce){
    // define currently social type, default is twitter
    $scope.currentSocialType = 'twitter';

    // define output default image path
    $scope.outputDefaultImg = '/image/arrow-up.png';

    // define ng-model data, "If you use ng-model, you have to have a dot in there." 
    // Without a dot, your child scope creates it's own value, overwriting the inherited value from the parent scope.
    $scope.ezDt = {
        // search keyword
        keyword : '',
        // search type is text
        keyword_type : 'text'
    }

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
        $scope.search();
    }

    /**
     * change input search type
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.updateSearchType = function(event){
        $scope.search();
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
        return '/template/socialOutput/' + $scope.currentSocialType + '_' + $scope.ezDt.keyword_type + '.html';
    }

    /**
     * click enter start search
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.searchPress = function(event){
        var keyCode = event.keyCode;
        if(keyCode == 13){
            $scope.search();
        }
    }

    /**
     * search 
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.search = function(){
        $scope.removeGuide = true;
        $scope.searchLoading = 'Loading...';

        // build url
        var url = '/social/' + $scope.currentSocialType + '/search';
        var data = {
            keyword : $scope.ezDt.keyword,
            keyword_type : $scope.ezDt.keyword_type
        }

        // post data
        $http({
            method: 'POST',
            url: url,
            data: $.param(data),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(res){
            $scope.searchLoading = false;

            if(res.error){
                $scope.noAccount = true;
                $scope.noAccountMessage = $sce.trustAsHtml( res.message );
            }else{
                $scope.socialData = res.data;
            }
        })
    }
});