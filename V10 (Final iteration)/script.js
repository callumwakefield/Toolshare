//variables
var sub_status = document.getElementById("reg_btn");
var checker = document.getElementById("reg_checkbox");


//only enables the register button when they 
//aggree to the terms and conditions
checker.onchange = function() {
    sub_status.disabled = !this.checked;
};
