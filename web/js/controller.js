ezstory.controller('postCtrl', function($scope, $http, $timeout, $sce){
    // get post header template
    $scope.getPostHeaderTpl = function(){
        return '/template/postHeader/index.html';
    }

    // get post body template
    $scope.getPostBodyTpl = function(){
        return '/template/postBody/index.html';
    }

    // show linked accounts
    $scope.showAccounts = function(event){
        var $obj = $(event.target);

        $obj.closest('.pw-span').find('.pw-account-wrap').slideToggle(800, 'easeOutBounce');
    }

    // show post body
    $scope.showPostBody = function(event){
        var $obj = $(event.target),
            type = $obj.attr('data-original-title');

        if($obj.hasClass('active')){
            $obj.removeClass('active');
            $('.p-w-pt[data-type="'+type+'"]').slideUp(800, 'easeOutBack');
        }else{          
            $obj.addClass('active');
            $('.p-w-pt[data-type="'+type+'"]').slideDown(800, 'easeOutBack');
        }
    }
});

ezstory.controller('socialCtrl', function($scope, $http, $timeout, $sce){
    // define currently social type, default is twitter
    $scope.currentSocialType = 'twitter';

    // define output default image path
    $scope.outputDefaultImg = '/image/arrow-up.png';

    // define social data is empty array
    $scope.socialData = [];

    // loading text 
    $scope.loadingText = "Load More";

    // define ng-model data, "If you use ng-model, you have to have a dot in there." 
    // Without a dot, your child scope creates it's own value, overwriting the inherited value from the parent scope.
    $scope.ezDt = {
        // search keyword
        keyword : '',
        // search type is text
        keyword_type : 'text'
    }

    /**
     * reset social data to empty array
     * @return {[type]} [description]
     */
    $scope.resetSocialDt = function(){
        $scope.socialData = [];
    }

    /**
     * change social type
     * @param  {[type]} event [description]
     * @return {[type]}       [description]
     */
    $scope.changeType = function(event){
        $scope.resetSocialDt();

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
        $scope.resetSocialDt();
        
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
    $scope.search = function(nextPage){
        $scope.removeGuide = true;
        $scope.searchLoading = 'Loading...';

        // build url
        var url = '/social/' + $scope.currentSocialType + '/search';
        var nextPage = nextPage ? nextPage : null;
        var data = {
            keyword : $scope.ezDt.keyword,
            keyword_type : $scope.ezDt.keyword_type
        }

        if(nextPage != null){
            data.next_page = nextPage;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param(data),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(res){
            $scope.loadingText = 'Load More';
            $scope.searchLoading = false;

            if(res.error){
                $scope.noAccount = true;
                $scope.noAccountMessage = $sce.trustAsHtml( res.message );
            }else{
                if(res.data){
                    if(nextPage){
                        $scope.socialData = $scope.socialData.concat(res.data);
                    }else{
                        $scope.socialData = res.data;
                    }
                }
                $scope.nextPage = res.next_page ? res.next_page : null;
            }
        })
    }


    /**
     * load more data for any social type
     * @return {[type]} [description]
     */
    $scope.loadMoreData = function(event){
        var $obj = $(event.target),
            originStr = $obj.html();

        $scope.loadingText = "Loading...";
        if($scope.nextPage != null){
            $scope.search( $scope.nextPage );
        }
    }
});