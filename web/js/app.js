// document ready
angular.element(document).ready(function () {
    // init tooltip
    // $('[data-toggle="tooltip"]').tooltip()
});


/**
 * main module
 * @type {[type]}
 */
var ezstory = angular.module('ezstory', [
    'ngRoute', 
    'ngSanitize'
]);


/**
 * number filters
 * @return {[type]}     [description]
 */
ezstory.filter("megaNumber", function(){
    return function(number, fractionSize){
        if(number === null) return null;
        if(number === 0) return "0";

        if(!fractionSize || fractionSize < 0){
            fractionSize = 1;
        }
                    
        var abs = Math.abs(number);
        var rounder = Math.pow(10,fractionSize);

        var isNegative = number < 0;
        var key = '';
        var powers = [
            {key: "Q", value: Math.pow(10,15)},
            {key: "T", value: Math.pow(10,12)},
            {key: "B", value: Math.pow(10,9)},
            {key: "M", value: Math.pow(10,6)},
            {key: "K", value: 1000}
        ];
        
        for(var i = 0; i < powers.length; i++) {
        
            var reduced = abs / powers[i].value;
        
            reduced = Math.round(reduced * rounder) / rounder;
        
            if(reduced >= 1){
                abs = reduced;
                key = powers[i].key;
                break;
            }
        }
        
        return (isNegative ? '-' : '') + abs + key;
    }
});

/**
 * convert datetime to timezone
 * @return {[type]}     [description]
 */
ezstory.filter("convert2Timezone", function(){
    return function(number){
        var d = new Date(number);
        return d.getTime();
    }
});


/**
 * Magnific Popup Display Video
 */
ezstory.directive('magnificPopupVideo', function(){
    return {
        restrict: 'A',
        link : function(scope, element){
            element.magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                closeOnBgClick : false,
                closeBtnInside: true,
            });
        }
    }
});


/**
 * Magnific Popup Display Image
 */
ezstory.directive('magnificPopupImage', function(){
    return {
        restrict: 'A',
        link : function(scope, element){
            element.magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: true,
                fixedContentPos: true,
                // class to remove default margin from left and right side
                mainClass: 'mfp-no-margins', 
                image: {
                    verticalFit: true
                },
            });
        }
    }
});

/**
 * Magnific Popup Ajax
 */
ezstory.directive('magnificPopupAjax', function(){
    return {
        restrict: 'A',
        link : function(scope, element){
            element.magnificPopup({
                type: 'ajax',
                closeOnContentClick: false,
                closeBtnInside: true,
                fixedContentPos: true,
                closeOnBgClick : false,
                // class to remove default margin from left and right side
                mainClass: 'mfp-no-margins', 
                image: {
                    verticalFit: true
                },
            });
        }
    }
});

/**
 * tooltips
 */
ezstory.directive('tooltips', function(){
    return {
        restrict: 'A',
        link : function(scope, element){
            element.tooltip();
        }
    }
});