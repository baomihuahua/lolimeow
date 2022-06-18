<?php
/**
* Template Name:Boxmoe外链提醒版
*/
$my_urls = array(
array('boxmoe','https://www.boxmoe.com'),
array('jsmoe','https://www.jsmoe.com')
);

if(strlen($_SERVER['REQUEST_URI']) > 384 || strpos($_SERVER['REQUEST_URI'], "eval(") || strpos($_SERVER['REQUEST_URI'], "base64")) {
@header("HTTP/1.1 414 Request-URI Too Long");
@header("Status: 414 Request-URI Too Long");
@header("Connection: Close");
@exit;
}
$go_url=htmlspecialchars(preg_replace('/^url=(.*)$/i','$1',$_SERVER["QUERY_STRING"]));
//自定义URL
foreach($my_urls as $x=>$x_value)
{
	if($go_url==$x_value[0]) {
		echo $go_url = $x_value[1];	
		}
}
if(!empty($go_url)) {
if ($go_url == base64_encode(base64_decode($go_url))) {
$go_url = base64_decode($go_url);
}
preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i',$go_url,$matches);
if($matches){
$url=$go_url;
$title= '安全中心 | 加载中...';
} else {
preg_match('/\./i',$go_url,$matche);
if($matche){
$url='https://'.$go_url;
$title= '安全中心 | 加载中...';
} else {
$err = '1';
$url = 'https://'.$_SERVER['HTTP_HOST'];
$title='参数错误，中止跳转！正在返回首页...';
}
}
} else {
$err = '1';	
$title ='参数缺失，中止跳转！正在返回首页...';
$url = 'https://'.$_SERVER['HTTP_HOST'];
}
?>
<!DOCTYPE html>
<html lang="zh-CN" class="io-white-mode">
<head>
<script>
    var default_c = "io-white-mode";
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)io_night_mode\s*\=\s*([^;]*).*$)|^.*$/, "$1"); 
    try {
        if (night === "0" || (!night && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
            document.documentElement.classList.add("io-black-mode");
            document.documentElement.classList.remove(default_c);
        } else {
            document.documentElement.classList.remove("io-black-mode");
            document.documentElement.classList.add(default_c);
        }
    } catch (_) {}
</script><meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes"> 
<meta name="robots" content="noindex,follow">
<title><?php bloginfo('name'); ?>-<?php echo $title;?></title>
<style>
body{margin:0;padding:0}body{height:100%}#loading{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:#e8eaec}.io-black-mode #loading{background:#1b1d1f}
.loading-content{position:absolute;top:10%;padding:0 10px;max-width:580px;z-index:10000000}.flex{display:flex}.flex-center{align-items:center}.flex-end{display:flex;justify-content:flex-end}.flex-fill{-ms-flex:1 1 auto !important;flex:1 1 auto !important}.logo-img{text-align:center}.logo-img img{width:200px;height:auto;margin-bottom:20px}.loading-info{padding:20px;background:#fff;border-radius:10px;box-shadow:0 15px 20px rgba(18,19,20,.2)}.loading-tip{background:rgba(255,158,77,.1);border-radius:6px;padding:5px}.loading-text{color:#b22e12;font-weight:bold}.loading-topic{padding:20px 0;border-bottom:1px solid rgba(136,136,136,.2);margin-bottom:20px;font-size:12px;word-break:break-all}a{text-decoration:none}.loading-btn,.loading-btn:active,.loading-btn:visited{color:#fc5531;border-radius:5px;border:1px solid #fc5531;padding:5px 20px;transition:.3s}.loading-btn:hover{color:#fff;background:#fc5531;box-shadow:0 15px 15px -10px rgba(184,56,25,0.8)}.loading-url{color:#fc5531}.taxt-auto{color:#787a7d;font-size:14px}.auto-second{color:#fc5531;font-size:16px;margin-right:5px;font-weight:bold}
.warning-ico{width:30px;height:26px;margin-right:5px;background-image:url("data:image/svg+xml,%3Csvg class='icon' viewBox='0 0 1024 1024' xmlns='http://www.w3.org/2000/svg' width='32' height='32'%3E%3Cpath d='M872.7 582.6L635.2 177c-53.5-91.3-186.6-88.1-235.6 5.7L187.7 588.3c-46.8 89.7 18.2 197 119.4 197h449.4c104 0 168.8-112.9 116.2-202.7zM496.6 295.2c0-20.5 11.7-31.5 35.1-32.9 22 1.5 33.7 12.5 35.1 32.9V315l-26.4 267.9h-13.2L496.6 315v-19.8zm35.2 406.3c-22-1.5-34.4-13.2-37.3-35.1 1.4-19 13.2-29.3 35.1-30.7 23.4 1.5 36.6 11.7 39.5 30.7-1.5 21.9-13.9 33.6-37.3 35.1z' fill='%23f55d49'/%3E%3C/svg%3E")}
.io-black-mode .loading-info{color:#eee;background:#2b2d2f}.io-black-mode .loading-text{color:#ff8369}
@media (min-width:768px){.loading-content{min-width:450px}}
</style>
</head>
<body class="go-to">
<div id="loading">
    <style>   
.loader{width:130px;height:170px;position:relative}
.loader::before,.loader::after{content:"";width:0;height:0;position:absolute;bottom:30px;left:15px;z-index:1;border-left:50px solid transparent;border-right:50px solid transparent;border-bottom:20px solid rgba(107,122,131,.15);transform:scale(0);transition:all 0.2s ease}
.loader::after{border-right:15px solid transparent;border-bottom:20px solid rgba(102,114,121,.2)}
.loader .getting-there{width:120%;text-align:center;position:absolute;bottom:0;left:-7%;font-family:"Lato";font-size:12px;letter-spacing:2px;color:#555}
.loader .binary{width:100%;height:140px;display:block;color:#555;position:absolute;top:0;left:15px;z-index:2;overflow:hidden}
.loader .binary::before,.loader .binary::after{font-family:"Lato";font-size:24px;position:absolute;top:0;left:0;opacity:0}
.loader .binary:nth-child(1)::before{content:"0";-webkit-animation:a 1.1s linear infinite;animation:a 1.1s linear infinite}
.loader .binary:nth-child(1)::after{content:"0";-webkit-animation:b 1.3s linear infinite;animation:b 1.3s linear infinite}
.loader .binary:nth-child(2)::before{content:"1";-webkit-animation:c 0.9s linear infinite;animation:c 0.9s linear infinite}
.loader .binary:nth-child(2)::after{content:"1";-webkit-animation:d 0.7s linear infinite;animation:d 0.7s linear infinite}
.loader.JS_on::before,.loader.JS_on::after{transform:scale(1)}
@-webkit-keyframes a{0%{transform:translate(30px,0) rotate(30deg);opacity:0}
100%{transform:translate(30px,150px) rotate(-50deg);opacity:1}
}@keyframes a{0%{transform:translate(30px,0) rotate(30deg);opacity:0}
100%{transform:translate(30px,150px) rotate(-50deg);opacity:1}
}@-webkit-keyframes b{0%{transform:translate(50px,0) rotate(-40deg);opacity:0}
100%{transform:translate(40px,150px) rotate(80deg);opacity:1}
}@keyframes b{0%{transform:translate(50px,0) rotate(-40deg);opacity:0}
100%{transform:translate(40px,150px) rotate(80deg);opacity:1}
}@-webkit-keyframes c{0%{transform:translate(70px,0) rotate(10deg);opacity:0}
100%{transform:translate(60px,150px) rotate(70deg);opacity:1}
}@keyframes c{0%{transform:translate(70px,0) rotate(10deg);opacity:0}
100%{transform:translate(60px,150px) rotate(70deg);opacity:1}
}@-webkit-keyframes d{0%{transform:translate(30px,0) rotate(-50deg);opacity:0}
100%{transform:translate(45px,150px) rotate(30deg);opacity:1}
}@keyframes d{0%{transform:translate(30px,0) rotate(-50deg);opacity:0}
100%{transform:translate(45px,150px) rotate(30deg);opacity:1}
}
.io-black-mode .loader .getting-there,.io-black-mode .loader .binary{color:#bbb}
</style>
<div class="loader JS_on">
	<span class="binary"></span>
	<span class="binary"></span>
	<span class="getting-there">LOADING STUFF...</span>
</div>    <div class="loading-content">
        <div class="logo-img">
            <?php echo boxmoe_logo();?>
        </div>
		<?php if($err != "1"){?>
        <div class="loading-info">                        
            <div class="flex flex-center loading-tip">                          
                <div class="warning-ico"></div><div class="loading-text">请注意您的账号和财产安全</div>                        
            </div>                        
            <div class="loading-topic">
                您即将离开 <?php bloginfo('name'); ?>，去往：<span class="loading-url"><?php echo $url;?></span>                       
            </div>                        
            <div class="flex flex-center"> 
                                <div class="taxt-auto"><span id="time" class="auto-second">2</span>秒后自动跳转</div> 
                <script type="text/javascript">  
                    delayURL();    
                    function delayURL() { 
                        var delay = document.getElementById("time").innerHTML;
                        var t = setTimeout("delayURL()", 2000);
                        if (delay > 0) {
                            delay--;
                            document.getElementById("time").innerHTML = delay;
                        } else {
                        clearTimeout(t); 
                            window.location.href = "<?php echo $url;?>";
                        }        
                    } 
                </script>                  
                <div class="flex-fill"></div>                     
                <a class="loading-btn" href="<?php echo $url;?>" rel="external nofollow">继续</a>                        
            </div>                      
        </div>
		<?php }else{ ?>
		<div class="loading-info">                        
            <div class="flex flex-center loading-tip">                          
                <div class="warning-ico"></div><div class="loading-text">目标网址未通过检测</div>                        
            </div>                        
            <div class="loading-topic">
                <?php echo $title;?>                       
            </div>                        
            <div class="flex flex-center"> 
                                <div class="taxt-auto"><span id="time" class="auto-second">2</span>秒后自动跳转</div> 
                <script type="text/javascript">  
                    delayURL();    
                    function delayURL() { 
                        var delay = document.getElementById("time").innerHTML;
                        var t = setTimeout("delayURL()", 2000);
                        if (delay > 0) {
                            delay--;
                            document.getElementById("time").innerHTML = delay;
                        } else {
                        clearTimeout(t); 
                            window.location.href = "<?php echo $url;?>";
                        }        
                    } 
                </script>
                   
                <div class="flex-fill"></div>                     
                <a class="loading-btn" href="<?php echo $url;?>" rel="external nofollow">继续</a>                        
            </div>                      
        </div>
		<?php }?>
   </div>
    </div>
<script>
    //延时30S关闭跳转页面，用于文件下载后不会关闭跳转页的问题
    setTimeout(function() {
        window.opener = null;
        window.close();
    }, 30000);
</script>
</body>
</html>