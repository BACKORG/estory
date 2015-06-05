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