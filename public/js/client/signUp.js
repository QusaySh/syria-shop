$(document).ready(function () {
    
    var num1 = Math.floor(Math.random() * 10) + 1;
    var num2 = Math.floor(Math.random() * 10) + 1;
    $("input#check").next("label").append(num1 + " + " + num2);
    $("input#check").keyup(function () {
        if ( $(this).val() == (num1 + num2) ) {
            $("button[name='signup']").toggleClass("disabled");
        } else {
            $("button[name='signup']").addClass("disabled");
        }
    });
    
});