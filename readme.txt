Steps for Installation

1. Unzip the file "MyCompnayWeb.zip"

2. Add uncompressed folder to addons inside modules of whmcs(modules/addons/)

3. Open whmcs admin and got setup-> aadon modules

4. Activate the MyCompnayWeb

5 You will be asked to enter Hostname, Username, and Password of the server where you want to upload the changed index.html page (Please make sure
that ftp has public_html directory in default directory).

6. When done save the changes, and you are done.

7. You can now see the addon name in Addons menu

8. Thanks for reading


*************************************NOTE****************************NOTE****************************************

Please make sure while editing source You take care of the following text. You should not delete any of that code Otherwise the addon wont work as expected.

**************************************************start**********************
<!--Please Never Edit followiing-->
<!--1) style="pointer-events: none;"-->
<!-- 2) class="makeEditable" contenteditable="false"-->
<!-- 3)   top menu - start  and  top menu - end --->
<!-- 5)  footer start here and footer end here-->
**************************************************end**********************


**************************************************start**********************
   <!--Newer modify following line or the associated files-->
   <script src="js/webfonts.js"></script>
   <!--temporarystartlinks--> <script>$(document).ready(function(){$("a").css("pointer-events","none")});</script><!--temporaryendlinks-->

**************************************************end**********************



*********************** VERSION 2 with LIVE CHAT*****************
Never replace or reorder this section script

<!--Start LiveChat-->
<script type="text/javascript">
window.__lc = window.__lc || {};
window.__lc.license = 2340051;
window.__lc.chat_between_groups = false;
(function() {
  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script>
<noscript>
<a href="https://www.livechatinc.com/chat-with/2340051/" rel="nofollow">Chat with us</a>,
powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
</noscript>
<!--End LiveChat-->



