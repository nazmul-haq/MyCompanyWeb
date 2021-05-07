/**
 * Created by saify on 11/9/16.
 */
$(document).ready(function(){
    $('body').prepend("<div class='topOverButtons'><input class='button-success' type='submit' value='EDIT' onClick='clickEdit(this)'></div>");
});

function clickEdit(ds)
{
if($(ds).attr('value')=='EDIT')
        {

            $('.makeEditable').attr('contenteditable',"true");
            $('.makeEditable').addClass('howeverEffect');
            $(ds).attr('value','DONE');
        }
        else if($(ds).attr('value')=='DONE')
        {


            $('.makeEditable').attr('contenteditable',"false");
            $('.makeEditable').removeClass('howeverEffect');
	    $('.topOverButtons').remove();
            $(html).find('.topOverButtons').remove();
            var html= "<!DOCTYPE html><html lang='en'>" + $("html").html() + "</html>";

            
           
            $.ajax({
                url: 'http://localhost/all_projects/whmcs_decoded/admin/addonmodules.php?module=MyCompnayWeb&ajax=1',
                type: 'POST',
                data: { 'html': html} ,
                success: function (response) {

		$('body').prepend("<div class='topOverButtons'><input class='button-success' type='submit'  value='EDIT' onClick='clickEdit(this)'></div>");
                },
                error: function () {
                    alert("Error submit page");
                }
            });
        }
}
