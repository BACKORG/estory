ezstory.controller('socialCtrl', function($scope, $http, $timeout){
    // define currently social type, default is twitter
    $scope.currentSocialType = 'twitter';
    // define default search type is text
    $scope.currentSocialSearchType = 'text';

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
});