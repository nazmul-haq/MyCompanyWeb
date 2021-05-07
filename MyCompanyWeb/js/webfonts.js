WebFont.load({
	    google: {
	      families: ['Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i']
	    }
	  });


/**
 * Created by saify on 11/9/16.
 */
$(document).ready(function(){



addTopMenu();





;
});

function closePopup()
{
$('.modal').hide()
}
function showPopup(ds)

{


	$('#linkHref').val($(ds).parent().find("a").attr('href'));
	$('#linkName').val($(ds).parent().find("a").html());
	$('.modal').show();
	$('.linksOnly').show();
	$('.logoOnly').hide();
	$('#saveBtn').click(function(){
	var html="<i class='fa fa-gear gearBtn' onClick='showPopup(this)'></i><a href='"+$('#linkHref').val()+"'>"+$('#linkName').val()+"</a>";
	$(ds).parent().html(html);

	});
	$('#saveCloseBtn').click(function(){
	var html="<i class='fa fa-gear gearBtn' onClick='showPopup(this)'></i><a href='"+$('#linkHref').val()+"'>"+$('#linkName').val()+"</a>";
	$(ds).parent().html(html);
        $('.modal').hide();
	});
}

function showPopupFooter(ds)
{
	$('#linkHref').val($(ds).parent().find("a").attr('href'));
	$('#linkName').val($(ds).parent().find("a").html());
	$('.modal').show();
	$('.linksOnly').show();
	$('.logoOnly').hide();
	$('#saveBtn').click(function(){
	var html="<i class='fa fa-gear gearFooter' onClick='showPopupFooter(this)'></i><a href='"+$('#linkHref').val()+"'>"+$('#linkName').val()+"</a>";
	$(ds).parent().html(html);

	});
	$('#saveCloseBtn').click(function(){
	var html="<i class='fa fa-gear gearFooter' onClick='showPopupFooter(this)'></i><a href='"+$('#linkHref').val()+"'>"+$('#linkName').val()+"</a>";
	$(ds).parent().html(html);
        $('.modal').hide();
	});
}

function showPopupLogo(ds)
{
	
	$('#logoLink').val($(ds).next().find('img').attr('src'));
        $('#linkHrefLogo').val($(ds).next().attr('href'));
	$('.logoOnly').show();
	$('.linksOnly').hide();
	$('.modal').show();
        $('.logoOnly p').show();
        $('#linkHrefLogo').show();
	$('#saveBtn').click(function(){	
	 $(ds).next().find('img').attr('src',$('#logoLink').val());
         $(ds).next().attr('href',$('#linkHrefLogo').val());
	});
	$('#saveCloseBtn').click(function(){	
	 $(ds).next().find('img').attr('src',$('#logoLink').val());
         $(ds).next().attr('href',$('#linkHrefLogo').val());
	$('.modal').hide();
	});
}
function showPopupLMore(ds)
{
	$('#linkHref').val($(ds).parent().find("a").attr('href'));
	$('#linkName').val($(ds).parent().find("a").html());
	$('.modal').show();
	$('.linksOnly').show();
	$('.logoOnly').hide();
	$('#saveBtn').click(function(){
       var html="<a href='"+$('#linkHref').val()+"' class='btns btn-orange'> "+$('#linkName').val()+" </a><i class='fa fa-gear gearBtnWhite' onclick='showPopupLMore(this)'></i>";

	$(ds).parent().html(html);
	});
	$('#saveCloseBtn').click(function(){

var html="<a href='"+$('#linkHref').val()+"' class='btns btn-orange'> "+$('#linkName').val()+" </a><i class='fa fa-gear gearBtnWhite' onclick='showPopupLMore(this)'></i>";

	$(ds).parent().html(html);
        $('.modal').hide();
	});

}
function showPopupONow(ds)
{
	$('#linkHref').val($(ds).parent().find("a").attr('href'));
	$('#linkName').val($(ds).parent().find("a").html());
	$('.modal').show();
	$('.linksOnly').show();
	$('.logoOnly').hide();
	$('#saveBtn').click(function(){
       var html="<a href='"+$('#linkHref').val()+"' class='btns btn-white'> "+$('#linkName').val()+" </a><i class='fa fa-gear gearBtnWhite' onclick='showPopupLMore(this)'></i>";

	$(ds).parent().html(html);
	});
	$('#saveCloseBtn').click(function(){

var html="<a href='"+$('#linkHref').val()+"' class='btns btn-white'> "+$('#linkName').val()+" </a><i class='fa fa-gear gearBtnWhite' onclick='showPopupLMore(this)'></i>";

	$(ds).parent().html(html);
        $('.modal').hide();
	});

}


function showPopupGetStarted(ds)
{
	$('#linkHref').val($(ds).parent().find("a").attr('href'));
	$('#linkName').val($(ds).parent().find("span").html());
	$('.modal').show();
	$('.linksOnly').show();
	$('.logoOnly').hide();
	$('#saveBtn').click(function(){

 var html="<i class='fa fa-gear gear1' onclick='showPopupGetStarted(this)'></i> <a href='"+$('#linkHref').val()+"' class='btn btns btn-orange'><span>"+$('#linkName').val()+"</span><i class='fa fa-long-arrow-right' aria-hidden='true'></i></a>";      

	$(ds).parent().html(html);
	});
	$('#saveCloseBtn').click(function(){

 var html="<i class='fa fa-gear gear1' onclick='showPopupGetStarted(this)'></i> <a href='"+$('#linkHref').val()+"' class='btn btns btn-orange'><span>"+$('#linkName').val()+"</span><i class='fa fa-long-arrow-right' aria-hidden='true'></i></a>";

	$(ds).parent().html(html);
        $('.modal').hide();
	});

}


function showPopupSocial(ds)
{

var cls=$($(ds).parent().find("a")).find('i').attr('class');
var soc=$($(ds).parent().find("a")).attr('class');
	$('#logoLink').val($(ds).parent().find("a").attr('href'));
	$('.modal').show();
	$('.linksOnly').hide();
        
	$('.logoOnly').show();
        $('.logoOnly p').hide();
        $('#linkHrefLogo').hide();
	$('#saveBtn').click(function(){
		
	
console.log("clikk--"+cls);
	var html="<div class='fa fa-gear gear2' onclick='showPopupSocial(this)'></div><a class='"+soc+"' href='"+$('#logoLink').val()+"'><i class='"+cls+"' aria-hidden='true'></i></a>";
$(ds).parent().html(html);
 	});
	$('#saveCloseBtn').click(function(){
		
console.log("clikk--"+cls);
		var html="<div class='fa fa-gear gear2' onclick='showPopupSocial(this)'></div><a class='"+soc+"' href='"+$('#logoLink').val()+"'><i class='"+cls+"' aria-hidden='true'></i></a>";
		$(ds).parent().html(html);	
        $('.modal').hide();
	});

}

function showPopupSubmit(ds)
{


	$('#logoLink').val($(ds).parent().parent().parent().attr('action'));
	$('.modal').show();
	$('.linksOnly').hide();
        
	$('.logoOnly').show();
        $('.logoOnly p').hide();
        $('#linkHrefLogo').hide();
	$('#saveBtn').click(function(){

        $(ds).parent().parent().parent().attr('action',$('#logoLink').val());
 	});
	$('#saveCloseBtn').click(function(){

	$(ds).parent().parent().parent().attr('action',$('#logoLink').val());	
        $('.modal').hide();
	});

}

function updatewhmcsMenu()
{
	
		
		var a=window.location.href.split("?");
		var url=a[1]+"?"+a[2];

            	var htmlheader= '<nav class="navbar navbar-default main-menu topmenubar">'+$(".topmenubar").html()+'</nav>';
		        var htmlfooter= '<footer class="footer">'+$(".footer").html()+'</footer>';
                var str=$("html").html();
		        var liveChat = str.substring(
                        str.lastIndexOf("<!--Start LiveChat-->") + 1, 
                        str.lastIndexOf("<!--End LiveChat-->")
                )+"<!--End LiveChat-->";
            	$.ajax({
                url: url+'&topheaderajax=1',
                type: 'POST',
                data: { 'htmlheader': htmlheader,'htmlfooter':htmlfooter,'htmlliveChat':liveChat} ,
                success: function (response) {
		            addTopMenu();
		            
		           alert("Your website's index.html, whmcs member area header/footer has been uploaded successfully ");
                //   var replacedPart = url.substring(url.lastIndexOf("whmcs/"), url.lastIndexOf("=MyCompanyWeb"));
                   
                   
                //   alert(top.location.href)
                //   var link = url.replace(replacedPart,"whmcs/admin/addonmodules.php?module");
                   
                 
                   window.parent.location = top.location.href;
                },
                error: function () {
                    alert("Error submit page");
                
                    window.parent.location.reload();
                }
            });
	
}

function addTopMenu()
{
var htmlTop="<div class='topOverButtons'><input class='button-success editbtn' type='submit' value='EDIT PAGE' onClick='clickEdit(this)'></div>";
htmlTop+="<div id='myModal' class='modal'><div class='modal-content'><span class='close' onClick='closePopup()'>x</span><br><div class='linksOnly'>";
htmlTop+="<p>Name</p> <input type='text' name='name' id='linkName'><br><br><p>Href</p> <input type='text' name='href' id='linkHref'><br><br>";
htmlTop+="</div><div class='logoOnly'><p>Preferred size for logo is (324x41)px</p><br><p>Paste Logo Link</p> <input type='text' name='name' id='logoLink'><br><br><p>Href</p> <input type='text' name='href' id='linkHrefLogo'><br><br><br></div>";
htmlTop+="<input type='submit' name='submit' class='button-success' id='saveBtn' value='Save'> <input type='submit' name='submit' class='button-success' id='saveCloseBtn' value='Save and Close'></div></div>";


    $('body').prepend(htmlTop);
}

function removeAllgears()
{
	    $('.gear2').remove();
            $('.makeEditable').attr('contenteditable',"false");
            $('.makeEditable').removeClass('howeverEffect');
	    $('.gearBtn').remove();
	    $('.gear1').remove();
	    $('.gearFooter').remove();            
	    $('.gearBtnWhite').remove();
	    $('.topOverButtons').remove();
            $('#myModal').remove();
}
function clickEdit(ds)
{
	if($(ds).attr('value')=='EDIT PAGE')
        {

            $('.makeEditable').attr('contenteditable',"true");
            $('.makeEditable').addClass('howeverEffect');
	    $('.menuClass  li').prepend("<i class='fa fa-gear gearBtn' onClick='showPopup(this)'></i>");
            $('.footerMenuClass  li').append("<i class='fa fa-gear gearFooter' onClick='showPopupFooter(this)'></i>");
            $('.getStartedMenu').prepend("<i class='fa fa-gear gear1' onClick='showPopupGetStarted(this)'></i>");
	    $('.lmore').append("<i class='fa fa-gear gearBtnWhite' onClick='showPopupLMore(this)'></i>");
            $('.onow').append("<i class='fa fa-gear gearBtnWhite' onClick='showPopupONow(this)'></i>");
            $('.logo').before("<i class='fa fa-gear gearBtn gear1' onClick='showPopupLogo(this)'></i>");
            $('.socials li').prepend("<i class='fa fa-gear gear2' onClick='showPopupSocial(this)'></i>");
            $('.search').append("<i class='fa fa-gear gear2' style='float:right;' onClick='showPopupSubmit(this)'></i>");
            $(ds).attr('value','DONE');
	    $('.whmcsupdate').show();
        }
        else if($(ds).attr('value')=='DONE')
        {


          

            
	if (confirm("Your website's index.html, whmcs member area header/footer will be updated. Press OK to confirm")) {

           
             removeAllgears();
            $(html).find('.topOverButtons').remove();
		var a=window.location.href.split("?");
		var url=a[1]+"?"+a[2];
var feedbackSection='<div class="container text-center"><h2>Our Customers LOVE us!</h2>';
   feedbackSection+='<div class="carousel-wrapper"><div class="owl-carousel owl-feedback" id="owl-feedback"><div>';
feedbackSection+='<div class="photo-bgr" data-coments="carousel-coment-1"><img src="img/photo3.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-2"><img src="img/photo4.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-3"><img src="img/photo2.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-4"><img src="img/photo4.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-5"><img src="img/photo5.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-6"><img src="img/photo1.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-7"><img src="img/photo1.png" alt=""></div></div><div><div class="photo-bgr" data-coments="carousel-coment-8"><img src="img/photo5.png" alt=""></div></div></div><div class="owl-carousel-coments"><p class="owl-carousel-coments-item active makeEditable" id="carousel-coment-1">I\'ve been very pleased with your services. You never cease to amaze me! The responses have been so great! And the problem is always solved. I\'ve referred you already to all my family and friends. Thank-you MyCompanyWeb!<span>Dorian Grey, Google CEO Corp</span></p><p class="owl-carousel-coments-item makeEditable" id="carousel-coment-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 2<span>Dorian Grey, Google CEO Corp</span></p><p class="owl-carousel-coments-item makeEditable" id="carousel-coment-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 3<span>Dorian Grey, Google CEO Corp</span></p><p class="owl-carousel-coments-item makeEditable" id="carousel-coment-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 4<span>Dorian Grey, Google CEO Corp</span></p><p class="owl-carousel-coments-item makeEditable" id="carousel-coment-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 5<span>Dorian Grey, Google CEO Corp</span></p><p class="owl-carousel-coments-item" id="carousel-coment-6">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 6<span>Dorian Grey, Google CEO Corp</span></p><p class="owl-carousel-coments-item makeEditable" id="carousel-coment-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 7<span>Dorian Grey, Google CEO Corp</span><p class="owl-carousel-coments-item makeEditable" id="carousel-coment-8">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum, cupiditate vero! Cumque laboriosam quas quam dolore, vel temporibus molestiae nesciunt, quo voluptatem architecto reiciendis blanditiis numquam. Excepturi, aliquid. Consectetur, quas. 8<span>Dorian Grey, Google CEO Corp</span></p></div><!-- owl-carousel-coments --></div><!-- carousel-wrapper --></div><!-- container -->';



                //$('.owl-carousel-coments').find('.makeEditable').removeAttr('contenteditable');
                //$('.owl-carousel-coments').find('.makeEditable').removeClass('makeEditable');
		var updatedcarosolcontent=$('.owl-carousel-coments').html();

                $('.feedbacks').html(feedbackSection);
		$('.owl-carousel-coments').html(updatedcarosolcontent);
		
		
		
		     var htmStr=$("html").html();
		     var replaceliveChatAutoFiles = htmStr.substring(
                        htmStr.lastIndexOf("<!--End LiveChat-->"), 
                        htmStr.lastIndexOf("</body>")
                );
                
                var withReplaced_1 = htmStr.replace(replaceliveChatAutoFiles,"<!--End LiveChat-->");
                
                var withReplaced = withReplaced_1.replace('<script type="text/javascript" async="" src="https://cdn.livechatinc.com/tracking.js"></script>','')
		
		
		

            var html= "<!DOCTYPE html><html lang='en'>" + withReplaced + "</html>";
            
            
            
              
            
           var loading=  '<div id="divLoading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%;';
           loading+=' background-color:#ffffff; z-index: 30001; opacity: 0.8;"><p style="font-size:20px;position: absolute; color: Black; top: 25%; left:25%;">';
           loading+='Updating index.html, whmcs member area header/footer, Please wait... <img src="img/mcwloading.gif"></p></div>';

$('body').prepend(loading);
            
            
                
            
            $.ajax({
                url: url+'&ajax=1',
                type: 'POST',
                data: { 'html': html} ,
                success: function (response) {
                    
		           updatewhmcsMenu();
	
	

                },
                error: function () {
                    alert("Error submit page");
                }
            });
}
        }
}
