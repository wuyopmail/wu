//首先我想说好,这是第一次写javascript.所有会出现的问题都是我将来进阶的垫脚石
===================================================
	1,			getElementById()
	2,			getElementsByTagName()
	3,function getElementsByClassName(node,classname){
		if(node.getElementsByClassName){
			//使用现有方法
			return node.getElementsByClassName(classname); 
		}
		else {
			var results = new Array();
			var elems =node.getElementByTagName("*");
			for(var i=0;i<elems.length;i++){
				if(elems(i).classname.indexOf(classname)!=-1)
				results[results.length]=elmes(i);
			}
			return results;
		}
	}
	4,			getAttribute()	//不属于document对象，不能通过document对象调用
	5,			setAttribute()	//只能通过元素节点对象调用 
	
====================================================

//把现有window.onload事件处理函数的值存入变量oldonload。
//如果在这个处理函数上还没有绑定任何函数，就像平时那样把新函数添加给它
//如果在这个处理函数上已经绑定了一些函数，就把新函数追加到现有指令的末尾
	function addLoadEvent(func){
		if(typeof window.onload!='function'){
			window.onload = func;
		}else{
			window.onload = function(){
				oldonload();
				func();
			}
		}
	}


addLoadEvent(prepareGallery);
addLoadEvent(chang_num);
addLoadEvent("");
addLoadEvent("");
addLoadEvent("");
addLoadEvent("");

window.onload = function(){
	prepareGallery();
	change_num();
}




//	showpic（whichpic）函数	whicpic是指某个元素节点，例<a>	用来修改图片占位符的src参数
function showpic(whichpic){
	if(!document.getElementById("placeholder"))return false;
	var source = whichpic.getAttribute("href");
	var placeholder = document.getElementById("placeholder");
	placeholder.setAttribute("src",source);
}

//	prepareGallery()函数		对每一个<a>标签绑定点击事件，点击会修改图片占位符 的src参数
function prepareGallery(){
	if(!document.getElementsByTagName)return false;
	if(!document.getElementById)return false;
	if(!document.getElementById("imagegallery"))return false;
	var garllery = document.getElementById("imagegallery");
	var links = garllery.getElementsByTagName("a");
	for(var i=0;i<links.length;i++){
		links[i].onclick = function(){
			showpic(this);
			return false;
		}
	}
}


var book_title;		//物品详情标题
//给物品详情添加标题
function showtitle(){
	book_title = document.getElementById("book-title");
	var h2 = book_title.getElementsByClassName("panel-title");
	var txt = document.createTextNode(book_title);
	h2.appendChild(txt);
}

var img_src;	//缩略图src属性
var img_title;	//缩略图title属性
//动态为缩略图<ul>标签添加<li>下的<a>标签，即添加一个缩略图链接
function addElement(){
	var garllery = document.getElementById("imagegallery");
	var li = document.createElement("li");
	var a = document.createElement("a");
	a.setAttribute("href",img_src);
	var img = document.createElement("img");
	img.setAttribute("src",img_src);
	img.setAttribute("title",img_title);
	img.setAttribute("class","small-img")
	li.appendChild("a");
	a.appendChild("img");
}

var img_nums	//缩略图的数量
//动态添加所有缩略图
function addElements(img_nums){
	for(var i=0;i<img_num;i++){
		addElement();
	}
}

var zuozhe,chubanshe,yeshu,chengse,isbn,price,oldprice;
//动态添加物品详细信息
function addBook_content(zuozhe,chubanshe,yeshu,chengse,isbn,price,oldprice){
	var book = document.getElementById("book");
	var book_con = book.getElementsByClassName("book-con");
	var span= book_con.getElementsByTagName("span");
		span[0].nodeValue = zuozhe;
		span[1].nodeValue = chubanshe;
		span[2].nodeValue = yeshu;
		span[3].nodeValue = chengse;
		span[4].nodeValue = isbn;
	var book_price = book.getElementsByClassName("book-price");
	var span= book_price.getElementsByTagName("span");
		span[0].nodeValue = price;
		span[1].nodeValue = oldprice;
}

//购物车数量增减事件
var cart_nums;
function change_num(){
	var add_num = document.getElementById("add-num");
	var jian = document.getElementById("jian");
	var jia = document.getElementById("jia");
	jian.onclick = function(){
		cart_nums--;
		add_num.value = cart_nums;
	}
	jia.onclick = function(){
		cart_nums++;
		add_num.value = cart_nums;
	}
}
window.onload = change_num();

//动态加载购物单
//	book_title price	上面已经设置该变量
function shopping_cart(book_title,price,cart_nums){
	var cart_con = document.getElementById("cart-con");
	var term;
	var td = Array();
	var tr = document.createElement("tr");
	var td[0] = document.createElement("td");
	tr.appendChild(td[0]);
	for(var i=1;i<7;i++){
		td[i]=document.createElement("td");
		td[i-1].append(td[i]);
	}
	cart_con.appendChild(tr);
	//table，tr,td,对应元素节点添加完成
	//td添加元素节点，并对应添加属性以及文本节点
	var inputs = document.createElement("input");
	var label = document.createElement("label");
	inputs.setAttribute("type","checkbox");
	inputs.setAttribute("name"," ");
	label.setAttribute("for"," ");
	inputs.append(label);
	//添加td[0]	勾选框
	td[0].appendChild(inputs);
	//添加td[1]	商品信息--img
	add_img(img_src);
	td[1].appendChild(a);
	//添加td[2]	商品信息--book_title
	add_btitle(book_title);
	td[2].appendChild(div);
	//添加td[3]	单价--price
	
	
}
//添加td[1]
function add_img(img_src){
	var a = document.createElement("a");
	a.setAttribute("href",img_src);
	var img = document.createElement("img");
	img.setAttribute("src",img_src);
	img.setAttribute("title",img_title);
	img.setAttribute("class","small-img")
	a.appendChild("img");
}
//添加td[2]
function add_btitle(img_title){
	var div = document.createElement("div");
	div.setAttribute("class"," ");
	div.nodeValue = img_title;
}
//添加td[3]
funtion add_td3(price){
	var span = document.createElement("span");
	span.setAttribute("class","")
	span.nodeValue = price;
}
