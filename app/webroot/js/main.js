//Start of Jquery Strict
(function ($) {
    "use strict";

    /*[ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })

    
    // Validate
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });

    //hide validation
    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    //validate input email
    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }
    //showing validation errors
    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }
    //hide validation errors
    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

  
	// $("#searchfield").focus(function(){
	// 	if($(this).val() == "Search contacts..."){
	// 		$(this).val("");
	// 	}
	// });
	// $("#searchfield").focusout(function(){
	// 	if($(this).val() == ""){
	// 		$(this).val("Search contacts...");
			
	// 	}
	// });

    //Modal Add New Message Trigger Modal
    $("#addMessage").click(function (){
        $("#addNewMessage").modal({backdrop: false}).modal("show");
        $("#MessageToId").select2({
        placeholder: "Select a recipient",
        allowClear: true
        });
        $('#content').append( '<div class="modal-backdrop fade show"></div>');
    });

    //Remove the appended backdrop div
    $('#addNewMessage').on('hide.bs.modal', function () {
        $('.modal-backdrop').remove();
    })

    // Edit User Birthdate
    $('.birthdate').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true
        });
    
    $("#test").focusout(function(){
        alert('test');
    });
    
    //search data in friend list
    $("#searchData").keyup(function(){
    
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
    
        // Loop through the data list
        $(".friendItem").each(function(){
    
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
    
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
    
        // Update the count
        var numberItems = count;
        $("#filter-count").text("Number of Filter = "+count);
    });

    //search data in message details
    $("#searchMessage").keyup(function(){
     
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
 
        // Loop through the data list
        $(".msg").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
 
        // Update the count
        var numberItems = count;
        $("#filter-count").text("Number of Filter = "+count);
    });
   
    
    // this is the id of the form
    $("#message-form").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        console.log(form.serialize());
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                console.log(data); // show response from the php script.
            }
            });
    });

    //Paginate Msg List
    var globalOffset = 2;
    $("#msgViewMore").on('click',function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        var formData = {
            post_per_page : 2,
            off_set : globalOffset
        };
        
        $.ajax({
            type: "POST",
            url: 'messages/myPaginate',
            data: formData, // serializes the form's elements.
            success: function(data)
            {   
                globalOffset += 2; // Update globalOffset var.

                $.each(data, function(i, item) {
                    //clone data
                    var $cloneData = $('#message_box').find('.friendItem').last().clone();
                    //check if image is not null then replace img
                    var chkImage = item['i']['image'];
                    ((chkImage) ? $cloneData.find('img')
                    .attr("src", "/Task/img/" + item['i']['image']) : $cloneData.find('img')
                    .attr("src", "/Task/img/default.png"))

                   //manipulating DOM elements
                    $cloneData.find('form:eq(0)')
                                         .attr("action", "/Task/messages/delete/" + item['ml']['user_id']);
                   $cloneData.find('a:eq(0)').attr("href", "messages?user_id=" + item['ml']['user_id']);
                   $cloneData.find('h6:eq(0)').html(item['i']['name']);
                   $cloneData.find('small:eq(0)').html(item['ml']['created']);
                   $cloneData.find('p:eq(0)').html(item['ml']['content']);
                    //append the clone data
                   $('#message_box').find('.friendItem').last().append($cloneData);
                    
                });
                
            }
            });
    });

    // //Paginate Msg Details
    // var globalOffset = 2;
    // $("#msgDetailMore").on('click',function(e) {

    //     e.preventDefault(); // avoid to execute the actual submit of the form.
    //     var formData = {
    //         user_id : $("#msgDetailMore").val(),
    //         post_per_page : 2,
    //         off_set : globalOffset
    //     };
        
    //     $.ajax({
    //         type: "POST",
    //         url: 'messages/msgPaginate',
    //         data: formData, // serializes the form's elements.
    //         success: function(data)
    //         {    
    //             console.log(data)
    //             globalOffset += 2; // Update globalOffset var.
               
    //             $.each(data, function(i, item) {
    //                 //clone data
    //                 if(formData.user_id == item['messages']['to_id'] || formData.user_id == item['messages']['form_id']){
    //                     var $cloneSender = $('.chat-box').find('#sender').last().clone();

    //                     $cloneSender.find('p').first().html(item['messages']['content']);
    //                     $cloneSender.find('p:eq(-1)').html(item['messages']['created']);
    //                     $('.chat-box').prepend($cloneSender);
    //                 }
    //                 else {
    //                     var cloneReceiver = $('.chat-box').find('#receiver').clone();
    //                     var chatBox = $('.chat-box');
    //                     var receiver = $('.chat-box').find('#receiver');
                       

    //                     if(cloneReceiver.length == 0){
    //                         chatBox.append('<div class="msg" id="receiver"></div>');
    //                         receiver.append('<div class="media w-50 mb-3"></div>');
    //                     //    var img = media.prepend('<img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle />');
    //                     //    var mediaBody = img.append('<div class="media-body ml-3"></div>');
    //                     //    var contentDiv = mediaBody.prepend('bg-light rounded py-2 px-3 mb-2');
    //                     //    var content = contentDiv.prepend('<p class="text-small mb-0 text-muted lh-25>'+ item['messages']['content'] +'</p>');
    //                     //    $dateCreated = $contentDiv.append('')
    //                     }
    //                     else{
    //                         $('.chat-box').find('.msg').last().append(cloneReceiver);
    //                     }
                        

    //                 }
                  
    //             });
                
    //         }
    //         });
    // });

})(jQuery);
//END of jquery