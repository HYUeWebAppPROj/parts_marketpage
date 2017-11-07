<!DOCTYPE html>
<head>
	<link href="mainpage.css" rel="stylesheet" type="text/css" />
	<link href="slider.css" rel="stylesheet" type="text/css" />
	<link href="marketpage.css" rel="stylesheet" type="text/css" />
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utp-8">

	<script type="text/javascript">
	function initMoving(target, position, topLimit, btmLimit) {
		if (!target)
			return false;

		var obj = target;
		var initTop = position;
		var bottomLimit = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight) - btmLimit - obj.offsetHeight;
		var top = initTop;

		obj.style.position = 'absolute';

		if (typeof(window.pageYOffset) == 'number') {
			var getTop = function() {
				return window.pageYOffset;
			}
		} else if (typeof(document.documentElement.scrollTop) == 'number') {
			var getTop = function() {
				return Math.max(document.documentElement.scrollTop, document.body.scrollTop);
			}
		} else {
			var getTop = function() {
				return 0;
			}
		}

		if (self.innerHeight) {
			var getHeight = function() {
				return self.innerHeight;
			}
		} else if(document.documentElement.clientHeight) {
			var getHeight = function() {
				return document.documentElement.clientHeight;
			}
		} else {
			var getHeight = function() {
				return 500;
			}
		}

		function move() {
			if (initTop > 0) {
				pos = getTop()-8;
			} else {
				pos = getTop() + getHeight() + initTop;
			}

			if (pos > bottomLimit)
				pos = bottomLimit;
			if (pos < topLimit)
				pos = topLimit;

			interval = top - pos;
			if(target == topmenu){
				top = top - interval /50;
				obj.style.top = top + 'px';
				
				if(pos > getTop()){
					window.setTimeout(function () {
					move();
					}, 0);
				}else{
					window.setTimeout(function () {
					move();
					}, 25);
				}
			}
			else if(target == sidebar){
				top = top - interval /500;
				obj.style.top = top + 'px';
				window.setTimeout(function () {
				move();
				}, 25);
			}
		}

		function addEvent(obj, type, fn) {
			if (obj.addEventListener) {
				obj.addEventListener(type, fn, false);
			} else if (obj.attachEvent) {
				obj['e' + type + fn] = fn;
				obj[type + fn] = function() {
					obj['e' + type + fn](window.event);
				}
				obj.attachEvent('on' + type, obj[type + fn]);
			}
		}

		addEvent(window, 'scroll', function () {
			move();
		});
	}

	function submitWin(form){ 
		window.open('',form.target,'width=800,height=700,scrollbars=yes'); 
		return true; 
	} 
</script>

<script>
	$(document).ready(function(){
		$('.checkallhtml').click(function(){
			$('.achtml').prop('checked', this.checked);
		});
	});
	$(document).ready(function(){
		$('.checkallcss').click(function(){
			$('.accss').prop('checked', this.checked);
		});
	});
	$(document).ready(function(){
		$('.checkalljs').click(function(){
			$('.acjs').prop('checked', this.checked);
		});
	});
	$(document).ready(function(){
		$('.checkallphp').click(function(){
			$('.acphp').prop('checked', this.checked);
		});
	});
</script>

	<title>CHAP</title>

</head>
<body>
	<?php //에러 출력안함 (사용이유 : 처음 마켓페이지실행시(즉,내가구매한 강의가 하나도없을경우==purarray.txt안에 내용이 없을경우) 오류가 발생하게됨)
	error_reporting(0);
	ini_set('display_errors', '0');
	?>

	<?php //purchasepage.php 팝업에서 구매한 강의를 purarray.txt파일에 줄단위로 저장
	if($_POST['recheck']){
		$rechs = $_POST['recheck'];
		$fp = fopen("purarray.txt", "a");
		foreach ($rechs as $rech) {
			fputs($fp,$rech);
			fputs($fp,"\r\n");
		}
		fclose($fp);
	} ?>
	<?php 
	$purfile = file('purarray.txt');
	$pursize = count($purfile);
	?>

	<form method="post" action="purchasepage.php" target="sendWin" onsubmit="return submitWin(this)">
		<div id="tim">
			<div class="header">
				<div class="wrap">
					<h1>
						<a href="mainpage.html"><img src="chap.png"/></a>
					</h1>
					<div class="top">
						<ul class="rt">
							<li><a class="rtlink" href="#">Log In</a></li>
						</ul>
					</div>
					<div id="topmenu">
						<ul class="menu">
							<li class="firstmenu"><a class="menulink firstmenu" href="studypage.html">html</a></li>
							<li><a class="menulink" href="studypage.html">css</a></li>
							<li><a class="menulink" href="studypage.html">javascript</a></li>
							<li><a class="menulink" href="studypage.html">php</a></li>
							<li><a class="menulink" href="marketpage.html">market</a></li>
							<li class="lastmenu"><a class="menulink lastmenu">my page</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="wrap">
			<div id="myinfo">
				<div class="menuname">
					내정보
				</div>
				<div class="yourpic">
					<img src="avatar.png"/>
				</div>
				<div>
					<ul>
						<li>
							코인 수 : <a href="#">0</a> 개
						</li>
						<li>
							구매한 강좌 수 : <a href="#"><?= $pursize ?></a> 개
						</li>
					</ul>
				</div>
				<input style="margin-top: 20px; width: 100%; height: 40px" type="submit" value="구매하기">
			</div>
			<div>
				<div class="shopmenu shopmenuright">
					<div class="shopname php">
						<label>PHP<input id="ckbt" type="checkbox" name="allphp" class="checkallphp"></label>
					</div>
					<div class="shopcont">
						<ul>
							<?php 
							$phs = file("market_php.txt"); //sql미사용 쉽게 txt로 구현 (market_html.txt 파일은 html강의 전체 목록)
							$torfphp = false;
							$fps = file("purarray.txt"); //sql미사용 쉽게 txt로 구현 (purarray.txt 파일은 내가 구매한 강의목록)

							foreach ($phs as $ph) {
								foreach ($fps as $fp) {
									if(strpos($fp, $ph) !== false){
										$torfphp = true;
										break;
									} ?>
						<?php   }
								if($torfphp == ture){ ?>
									<li><?= $ph ?></li>
						<?php   }else{ ?>
								<li><label><?= $ph ?><input id="ckbt" type="checkbox" name="mck[]" class="acphp" value=<?= $ph ?>></label></li>
						<?php   }
								$torfphp = false; ?>
					<?php   } ?>
						</ul>
					</div>
				</div>
				<div class="shopmenu">
					<div class="shopname js">
						<label>JS<input id="ckbt" type="checkbox" name="alljs" class="checkalljs"></label>
					</div>
					<div class="shopcont">
						<ul>
							<?php 
							$jss = file("market_js.txt"); //sql미사용 쉽게 txt로 구현 (market_html.txt 파일은 html강의 전체 목록)
							$torfjs = false;
							$fps = file("purarray.txt"); //sql미사용 쉽게 txt로 구현 (purarray.txt 파일은 내가 구매한 강의목록)

							foreach ($jss as $js) {
								foreach ($fps as $fp) {
									if(strpos($fp, $js) !== false){
										$torfjs = true;
										break;
									} ?>
						<?php   }
								if($torfjs == ture){ ?>
									<li><?= $js ?></li>
						<?php   }else{ ?>
								<li><label><?= $js ?><input id="ckbt" type="checkbox" name="mck[]" class="acjs" value=<?= $js ?>></label></li>
						<?php   }
								$torfjs = false; ?>
					<?php   } ?>
						</ul>
					</div>
				</div>
				<div class="shopmenu">
					<div class="shopname html">
						<label>HTML<input id="ckbt" type="checkbox" name="allhtml" class="checkallhtml"></label>
					</div>
					<div class="shopcont">
						<ul>
							<?php 
							$htmls = file("market_html.txt"); //sql미사용 쉽게 txt로 구현 (market_html.txt 파일은 html강의 전체 목록)
							$torfhtml = false;
							$fps = file("purarray.txt"); //sql미사용 쉽게 txt로 구현 (purarray.txt 파일은 내가 구매한 강의목록)

							foreach ($htmls as $html) {
								foreach ($fps as $fp) {
									if(strpos($fp, $html) !== false){
										$torfhtml = true;
										break;
									} ?>
						<?php   }
								if($torfhtml == ture){ ?>
									<li><?= $html ?></li>
						<?php   }else{ ?>
								<li><label><?= $html ?><input id="ckbt" type="checkbox" name="mck[]" class="achtml" value=<?= $html ?>></label></li>
						<?php   }
								$torfhtml = false; ?>
					<?php   } ?>
					
						</ul>
					</div>
				</div>
				<div class="shopmenu">
					<div class="shopname css">
						<label>CSS<input id="ckbt" type="checkbox" name="allcss" class="checkallcss"></label>
					</div>
					<div class="shopcont">
						<ul>
							<?php 
							$csss = file("market_css.txt"); //sql미사용 쉽게 txt로 구현 (market_html.txt 파일은 html강의 전체 목록)
							$torfcss = false;
							$fps = file("purarray.txt"); //sql미사용 쉽게 txt로 구현 (purarray.txt 파일은 내가 구매한 강의목록)

							foreach ($csss as $css) {
								foreach ($fps as $fp) {
									if(strpos($fp, $css) !== false){
										$torfcss = true;
										break;
									} ?>
						<?php   }
								if($torfcss == ture){ ?>
									<li><?= $css ?></li>
						<?php   }else{ ?>
								<li><label><?= $css ?><input id="ckbt" type="checkbox" name="mck[]" class="accss" value=<?= $css ?>></label></li>
						<?php   }
								$torfcss = false; ?>
					<?php   } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		var bool = true;      //메뉴바 활성화 비활성화 (true면 활성화)
		if(bool == true){
			initMoving(document.getElementById("topmenu"), 100, 110, 0); 
		}

		window.name = "mom";
	</script>
</body>

</html>