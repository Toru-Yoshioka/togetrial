/* snowparticle.smart.1.js */
(function(d,b,w){
	/* 直リン対策用 自サーバーアップロードしてお使いいただける場合は3〜11行目まで削除してお使いください。 */
	if(!location.href.match(/^http:\/\/actyway\.com\//)){
		var j = d.getElementsByTagName('script');
		for(var x=0;x<j.length;x++){
			if(j[x].src.match(/^http:\/\/actyway\.com\//)){
				return false;
			}
		}
	}
	var q = d.createElement('div');
	q.id = 'snowparticle';
	b.appendChild(q);
	q = d.getElementById('snowparticle');
	b.style.overflowX = 'hidden';
	var h = w.innerHeight;
	var u = d.documentElement.scrollTop || b.scrollTop;
	var e = u+h+10;
	var p = 7;
	var z = 9999;
	var t = new Array();
	var l = new Array();
	var y = new Array();
	var s = new Array();
	var g = new Array();
	var c = new Array();
	d.addEventListener('scroll',function(){u = d.documentElement.scrollTop || b.scrollTop;e = u+h+10;},false);
	for(var i=0;i<20;i++){
		var m = d.createElement('div');
		m.id = 'yuki'+i;
		t[i] = Math.random()*-h+Math.random()*(h/2)+u;
		l[i] = Math.random()*w.innerWidth;
		m.setAttribute('style','position:absolute;z-index:'+(z+i)+';top:-'+t[i]+'px;width:'+p+'px;height:'+p+'px;background:rgba(255,255,255,0.8);border-radius:5px;left:'+l+'px;');
		m.setAttribute('class','snow');
		q.appendChild(m);
		y[i] = Math.random()*25+0.1;
		s[i] = Math.random()*4+0.7;
		g[i] = d.getElementById('yuki'+i);
		c[i] = 0;
	}
	setInterval(function(){
		for(var i=0;i<20;i++){
			if(e>t[i]){
				if(y[i]>=c[i]){
					l[i] = l[i]+0.5+Math.random()*0.5;
				}else{
					l[i] = l[i]-0.5-Math.random()*0.5;
				}
				if((y[i]*2)<=c[i]){
					c[i] = 0;
				}
			}else{
				t[i] = u-10;
				l[i] = Math.random()*w.innerWidth;
			}
			t[i] = t[i]+s[i];
			g[i].style.top = t[i]+'px';
			g[i].style.left = l[i]+'px';
			c[i]++;
		}
	},50);
})(document,document.body,window);