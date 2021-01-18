var exp_array = [];

(function ( $ ) {
    $.fn.multiStepForm = function(args) {
        if(args === null || typeof args !== 'object' || $.isArray(args))
            throw  " : Called with Invalid argument";
            var form = this;
            var tabs = form.find('.tab');
            var steps = form.find('.step');
            steps.each(function(i, e){
                $(e).on('click', function(ev){
                });
            });
            form.navigateTo = function (i) {/*index*/
            tabs.removeClass('current').eq(i).addClass('current');
            form.find('.previous').toggle(i > 0);
            atTheEnd = i >= tabs.length - 1;
            form.find('.next').toggle(!atTheEnd);
            form.find('.submit').toggle(atTheEnd);
            fixStepIndicator(curIndex());
            return form;
        }
        function curIndex() {
            return tabs.index(tabs.filter('.current'));
        }
        function fixStepIndicator(n) {
            steps.each(function(i, e){
                i == n ? $(e).addClass('active') : $(e).removeClass('active');
            });
        }
        form.find('.previous').click(function() {
            form.navigateTo(curIndex() - 1);
        });

        form.find('.next').click(function () {
            if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
                if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
                    form.validate(args.validations);
                    validateExtraField();
                    validateExtraFieldLangs();
                    validateExtraFieldTech();
                    validateExtraFieldReference();
                    
                    if(form.valid() == true){
                        form.navigateTo(curIndex() + 1);
                        return true;
                    }
                    return false;
                }
            }
            form.navigateTo(curIndex() + 1);
        });
        form.find('.submit').on('click', function(e){
            if(typeof args.beforeSubmit !== 'undefined' && typeof args.beforeSubmit !== 'function')
                args.beforeSubmit(form, this);
            if(typeof args.submit === 'undefined' || (typeof args.submit === 'boolean' && args.submit)){
                form.submit();
            }
            return form;
        });
        typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;
        form.noValidate = function() {
    
        }
        return form;
    };
}( jQuery ));

$(document).ready(function () {

    var d = new Date();
    var Y = d.getFullYear();
    var M = parseInt(d.getMonth());
    var D = parseInt(d.getDate()) + 1;
    $(".birthdate").datetimepicker({
        ignoreReadonly: true,
        useCurrent: false,
        format: 'MM/DD/YYYY',
        maxDate: new Date(Y, M, D),
        disabledDates: [
            new Date(Y, M, D)
        ],
    });

    $(".btn-add-more-exp,.or_add").show();

    $.validator.addMethod('date', function (value, element, param) {
        return (value != 0) && (value <= 31) && (value == parseInt(value, 10));
    }, 'Please enter a valid date!');
    $.validator.addMethod('month', function (value, element, param) {
        return (value != 0) && (value <= 12) && (value == parseInt(value, 10));
    }, 'Please enter a valid month!');
    $.validator.addMethod('year', function (value, element, param) {
        return (value != 0) && (value >= 1900) && (value == parseInt(value, 10));
    }, 'Please enter a valid year not less than 1900!');


    $.validator.addMethod('username', function (value, element, param) {
        var nameRegex = /^[a-zA-Z0-9]+$/;
        return value.match(nameRegex);
    }, 'Only a-z, A-Z, 0-9 characters are allowed');

    var val = {
        errorPlacement: function (error, element) {
            if (element.parent('div').hasClass('parent-checkbox')) {
                error.appendTo(element.parent().parent().parent());
            } else  if (element.parents('div').hasClass('languges-option')) {
                error.appendTo(element.parent().parent().parent().parent());
            } else if (element.parent('div').hasClass('parent-radio')) {
                error.appendTo(element.parent().parent().parent());
            } else  if (element.parents('div').hasClass('technology-option')) {
                error.appendTo(element.parent().parent().parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            fname: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            lname: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            email: {
                required: true,
                email: true
            },
            address1: {
                required: true,
                minlength: 5,
                maxlength: 100,
            },
            state: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            city: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            postcode: {
                required: true,
                digits: true,
                minlength: 4,
                maxlength: 10,
            },
            phone_number: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },
            "ssc[nob]": {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            "ssc[year]": {
                required: true,
                minlength: 2,
                maxlength: 10,
                digits: true
            },
            "ssc[percentage]": {
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
            "hsc[nob]": {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            "hsc[year]": {
                required: true,
                minlength: 2,
                maxlength: 10,
                digits: true
            },
            "hsc[percentage]": {
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
            "be[course]": {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            "be[university]": {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            "be[year]": {
                required: true,
                minlength: 2,
                maxlength: 50,
                digits: true
            },
            "be[percentage]": {
                required: true,
                minlength: 2,
                maxlength: 50,
                digits: true
            },
            "me[course]": {
                // required:   true,
                minlength: 2,
                maxlength: 50,
            },
            "me[university]": {
                // required:   true,
                minlength: 2,
                maxlength: 50,
            },
            "me[year]": {
                // required:   true,
                minlength: 2,
                maxlength: 50,
                digits: true
            },
            "me[percentage]": {
                // required:   true,
                minlength: 2,
                maxlength: 50,
                digits: true
            },
            "notice_period": {
                required: true,
                minlength: 2,
                maxlength: 20,
            },
            "expected_ctc": {
                required: true,
                minlength: 2,
                maxlength: 20,
            },
            "current_ctc": {
                required: true,
                minlength: 2,
                maxlength: 20,
            },
        },
        messages: {
            fname: {
                required:   "Please enter firstname",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            lname: {
                required:   "Please enter lastname",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            email: {
                required:   "Email is required",
                email:      "Please enter a valid e-mail",
            },
            address1: {
                required:   "Please enter address1",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            state: {
                required:   "Please enter state",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            city: {
                required:   "Please enter city",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            postcode:{
                required:   "Please enter postcode",
                minlength:  "Please enter 4 digit mobile number",
                maxlength:  "Please enter 10 digit mobile number",
                digits:     "Only numbers are allowed in this field"
            },
            phone_number:{
                required:   "Please enter phone number",
                minlength:  "Please enter 10 digit mobile number",
                maxlength:  "Please enter 10 digit mobile number",
                digits:     "Only numbers are allowed in this field"
            },
            "ssc[nob]":{
                required:   "Please enter name of board",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            "ssc[year]":{
                required:   "Please enter year",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "ssc[percentage]":{
                required:   "Please enter percentage",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "hsc[nob]":{
                required:   "Please enter name of board",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            "hsc[year]":{
                required:   "Please enter year",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "hsc[percentage]":{
                required:   "Please enter percentage",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "be[course]":{
                required:   "Please enter course name",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            "be[university]":{
                required:   "Please enter university",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            "be[year]":{
                required:   "Please enter year",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "be[percentage]":{
                required:   "Please enter percentage",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "me[course]":{
                required:   "Please enter course name",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            "me[university]":{
                required:   "Please enter university",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            "me[year]":{
                required:   "Please enter year",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            "me[percentage]":{
                required:   "Please enter percentage",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
                digits:     "Only numbers are allowed in this field"
            },
            notice_period:{
                required:   "Please enter notice period",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            expected_ctc:{
                required:   "Please enter expected ctc",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
            current_ctc:{
                required:   "Please enter current ctc",
                minlength:   "Minimum {0} characters are required",
                maxlength:   "Maximum {0} characters are allowed",
            },
        } 
    }

    $("#postJobForm").multiStepForm(
    {
        // defaultStep:0,
        beforeSubmit : function(form, submit){
            // console.log("called before submiting the form");
            // console.log(form);
            // console.log(submit);
        },
        validations:val,
    }
    ).navigateTo(0);

    $(document).on('click','.btn-add-more-exp',function(){
        validateExtraField();
        
        var is_valid = true;
        $('#work-eperieance input').each(function() {
            $('#postJobForm').validate().element(this);
            if(!$(this).valid()){
                is_valid = $(this).valid();
            }
        });
        if(is_valid){
            var workDetails = $(".work-exp-details .work-exp-item").eq(0).clone();
            ex_count++;
            
            workDetails.find('.exp_to_date input').prop('disabled',false);
            workDetails.find('.validation-error-label').remove();
            workDetails.find('input.id').remove();
            workDetails.find('input').each(function() {
                this.name = this.name.replace(/\[\d\]+/, '[' + ex_count + ']');
                this.value = "";
            });
            $('.work-exp-details').append(workDetails);
            workDetails.find('.work_is_present').attr('value', 1);
        }
    });
    $(document).on('click','.delete-work-exp',function(e){
        var data_id = $(this).parents('.work-exp-item').find("input[type='hidden'].id").val();
        if($('#is_experience').is(":checked") || $('.work-exp-item').length > 1){
            $(this).parents('.work-exp-item').remove();
    
            if(data_id != "") {
                exp_array.push(data_id);
                $('#exp_remove_arr').val(JSON.stringify(exp_array));
            }
        }else{
            alert('At least one required');
        }
    });
    
    $(document).on('click','.btn-add-more-reference',function(){
        validateExtraFieldReference();
        
        var is_valid = true;
        $('#reference-contact input').each(function() {
            $('#postJobForm').validate().element(this);
            if(!$(this).valid()){
                is_valid = $(this).valid();
            }
        });
        if(is_valid){
            var workDetails = $(".reference-contact-details .reference-item").eq(0).clone();
            reference_count++;
            
            workDetails.find('.exp_to_date input').prop('disabled',false);
            workDetails.find('.validation-error-label').remove();
            workDetails.find('input.id').remove();
            workDetails.find('input').each(function() {
                this.name = this.name.replace(/\[\d\]+/, '[' + reference_count + ']');
                this.value = "";
            });
            $('.reference-contact-details').append(workDetails);
            workDetails.find('.work_is_present').attr('value', 1);
        }
    });
    $(document).on('click','.delete-reference-contact',function(e){
        var data_id = $(this).parents('.reference-item').find("input[type='hidden'].id").val();
        if($('#is_experience').is(":checked") || $('.reference-item').length > 1){
            $(this).parents('.reference-item').remove();
    
            if(data_id != "") {
                exp_array.push(data_id);
                $('#exp_remove_arr').val(JSON.stringify(exp_array));
            }
        }else{
            alert('At least one required');
        }
    });
    
});

function validateExtraField() {
    // console.log('validateExtraField called');
    $('.company_name').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter company name",
                maxlength: "Maximum {0} characters are allowed",
            }
        });
    });

    $('.designation').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter designation",
                maxlength: "Maximum {0} characters are allowed",
            }
        });
    });
    $('.from').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter date",
                // maxlength: "Maximum {0} characters are allowed",
            }
        });
    });
    $('.to').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter date",
                // maxlength: "Maximum {0} characters are allowed",
            }
        });
    });
}
function validateExtraFieldReference() {
    // console.log('validateExtraFieldReference called')
    $('.name').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter name",
                maxlength: "Maximum {0} characters are allowed",
            }
        });
    });

    $('.phone').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter phone",
                maxlength: "Maximum {0} characters are allowed",
            }
        });
    });
    $('.relation').each(function() {
        $(this).rules('add', {
            required: true,
            normalizer: function(value) {return $.trim(value);},
            maxlength: 100,
            messages: {
                required:  "Please enter relation",
                // maxlength: "Maximum {0} characters are allowed",
            }
        });
    });
}

// Language wise selection and option enable/desable
    
$(document).on('click', '.lang-name', function () {
    var _this = $(this);

    if (_this.prop('checked') === true) {
        $(document).find('.lang-option' + _this.data('id')).prop('disabled',false);
    } else {
        $(document).find('.lang-option' + _this.data('id')).prop('disabled',true);
    }
});

$(document).on('click', '.prog-lang-name', function () {
    var _this = $(this);

    if (_this.prop('checked') === true) {
        $(document).find('.prog-lang-option' + _this.data('id')).prop('disabled',false);
    } else {
        $(document).find('.prog-lang-option' + _this.data('id')).prop('disabled',true);
    }
});

$(document).on('click', '.lang-name', function () {
    if ($("input[name*='language']:checked").length > 0) { 
        $('#HINDI1').rules('remove', "required");
    } else {
        validateExtraFieldLangs();
    }
    $("#postJobForm").valid();
})
$(document).on('click','.prog-lang-name', function(){
    if ($("input[name*='technology']:checked").length > 0) { 
        $('#PHP1').rules('remove', "required");
    } else {
        validateExtraFieldTech();   
    }
    $("#postJobForm").valid();
})
$(document).on('click','.sub-checkbox', function(){
    $("#postJobForm").valid();
})
$(document).on('click','.sub-radio', function(){
    $("#postJobForm").valid();
})

function validateExtraFieldLangs() {
    $('.lang-name').each(function (key, val) {
        var _id = $(this).data('id');
        var concat_id = $(this).data('key') + $(this).data('id');
      
        if ($("input[name*='language']:checked").length == 0) {
            $('#'+concat_id).rules('add', {
                required: true,
                messages :{
                    required : "Please select at least one language",
                }
            });
            return false
        }

        if ($('input[name*="language['+$(this).data('id')+']"]').prop('checked') == true ) {
            $('#read'+_id).rules('add', {
                required: {
                    depends: function () {
                        if ($('input[name*="read[' + _id+']"]').prop('checked') == false &&
                            $('input[name*="write[' + _id+']"]').prop('checked') == false &&
                            $('input[name*="speak[' + _id+']"]').prop('checked')  == false) {
                            return true;
                        }
                        return false;
                    }
                },
                messages :{
                    required : "Please check at lease one checkbox",
                }
            });
        }
    });
}
function validateExtraFieldTech() {
    $('.prog-lang-name').each(function (key, val) {
        var _id = $(this).data('id');
        var concat_id = $(this).data('key') + $(this).data('id');
        if(key == 0  && $("input[name*='technology']:checked").length == 0){
            $('#'+concat_id).rules('add', {
                required: true,
                messages :{
                    required : "Please select at least one technology",
                }
            });
            return false
        }

        if ($('input[name*="technology['+$(this).data('id')+']"]').prop('checked') == true ) {
            $('input[name*="technology' + _id+'"]').rules('add', {
                required: true,
                messages :{
                    required : "Please select at least one level",
                }
            });
        }
    });
}
